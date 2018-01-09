@extends('layouts.master')
@section('content')
@include('layouts.partials.header',['hidden_sidebar' => true])
@include('layouts.partials.sidebar')
<div class="listing-wrapper @if(!$benchmarks->count()) no-data @endif">
    @if($benchmarks->count())
        <div class="listing-inner">
            <div class="container">
                <h1 class="page-title">
                My Benchmarks
                </h1>

                <table id="listing-table" class="data-table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Benchmark Name</th>
                            <th data-sortable="true">Start Date</th>
                            <th data-sortable="true">End Date</th>
                            <th data-sortable="true">Date of creation</th>
                            <th data-sortable="true">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($benchmarks as $key => $benchmark)
                        <tr id="benchmark-{{$benchmark->id}}" data-index="{{$key}}">
                            <td class="table-benchmark-name">
                                <a href="/benchmarks/{{ $benchmark->id }}">
                                    {{  $benchmark->title }}
                                </a>
                            </td>
                            <td class="table-digit">{{ $benchmark->since }}</td>
                            <td class="table-digit">{{ $benchmark->until }}</td>
                            <td class="table-digit">{{ $benchmark->created_at->toDateString() }}</td>
                            <td class="table-digit">
                                <span class="label label-{{ $benchmark->getStatus()['class'] }}">{{ $benchmark->getStatus()['text'] }}</span>
                            </td>

                           <!--  <td>
                                <button  class="table-delete" data-id="{{ $benchmark->id }}">
                                    <i class="b-trash"></i>
                                </button>
                            </td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="fb-wrapper">
    @if(!$hasBenchmarks)
        <form id="submit_pages" action="{{ route('newDemoBench') }}" method="POST" class="fb-form">
            {{ csrf_field() }}
            <div class="fb-header">
                <h1>
                 Create your first Free <b>Benchmark.</b>
                </h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li id="fb-tab-li" role="presentation" class="active">
                    <i class="b-clipboard"></i>
                    <span>Add Pages</span>
                </li>
                <li id="date-tab-li" role="presentation">
                    <i class="b-calendar"></i>
                    <span>Select Periode</span>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fb-tab fade in active" id="fb-tab">
                    <div class="fb-header">
                        <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
                    </div>
                    <div class="fb-inner  fb-form-inner">
                        <div class="media fb-box focused">
                            <div class="media-left fb-icon">
                                <i class="icon-facebook"></i>
                                <i class="icon-ok"></i>
                                <i class="icon-cancel"></i>
                                <i class="icon-spin5 animate-spin"></i>
                            </div>
                            <div class="media-body fb-inner">
                                <label class="fb-nb" for="fb_page_1">First page</label>
                                <input name="accounts[]" id="fb_page_1" class="fb-input" type="text" name="fb_page_1" placeholder="https://www.facebook.com/exemple">
                            </div>
                        </div>
                        <div class="media fb-box">
                            <div class="media-left fb-icon">
                                <i class="icon-facebook"></i>
                                <i class="icon-ok"></i>
                                <i class="icon-cancel"></i>
                                <i class="icon-spin5 animate-spin"></i>
                            </div>
                            <div class="media-body fb-inner">
                                <label class="fb-nb" for="fb_page_2">Second page</label>
                                <input name="accounts[]" id="fb_page_2" class="fb-input" type="text" name="fb_page_2" placeholder="https://www.facebook.com/exemple">
                            </div>
                        </div>
                    </div>

                    <div class="fb-footer clearfix">
                        <button class="mbtn mbtn-icon next-btn" id="nextStep" disabled aria-controls="date-tab" role="tab" data-toggle="tab">
                            <span>Next</span>
                            <i class="b-angle-right"></i>
                            <i class="icon-spin5 animate-spin"></i>
                        </button>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane period-tab fade in" id="date-tab">
                    <div class="fb-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <label>
                                    Benchmark Name
                                </label>
                                <div class="input-container">
                                    <input class="form-control" id="title" type="text" name="title" placeholder="Benchmark">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>Choose the time periods for your benchmark report.</p>
                            </div>


                            <div class="col-md-6" id="difTime">
                                <span>Benchmark 7 Days</span>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong class="price">5 USD</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                VAT
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong>0 USD</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <strong>TOTAL</strong>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong class="price">5 USD</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fb-footer clearfix">
                        <div class="fb-footer-inner">
                            <button id="initStripe" type="submit"  class="hidden" waves-hover></button>
                            <button type="submit" id="generateBench" class="mbtn">
                                <span>Purchase</span>
                            </button>
                        </div>

                        <a id="backBtn" class="mbtn mbtn-default mbtn-icon prev-btn" href="#fb-tab" aria-controls="fb-tab" role="tab" data-toggle="tab">
                            <i class="b-angle-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    @else
        <form id="submit_pages" action="/checkout/new" method="POST" class="fb-form">
            {{ csrf_field() }}
            <div class="fb-header">
                <h1>
                @if($benchmarks->count())
                    Make another <b>Benchmark.</b>
                @else
                    Create your first <b>Benchmark.</b>
                @endif
                </h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li id="fb-tab-li" role="presentation" class="active">
                    <i class="b-clipboard"></i>
                    <span>Add Pages</span>
                </li>
                <li id="date-tab-li" role="presentation">
                    <i class="b-calendar"></i>
                    <span>Select Periode</span>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fb-tab fade in active" id="fb-tab">
                    <div class="fb-header">
                        <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
                    </div>
                    <div class="fb-inner  fb-form-inner">
                        <div class="media fb-box focused">
                            <div class="media-left fb-icon">
                                <i class="icon-facebook"></i>
                                <i class="icon-ok"></i>
                                <i class="icon-cancel"></i>
                                <i class="icon-spin5 animate-spin"></i>
                            </div>
                            <div class="media-body fb-inner">
                                <label class="fb-nb" for="fb_page_1">First page</label>
                                <input name="accounts[]" id="fb_page_1" class="fb-input" type="text" name="fb_page_1" placeholder="https://www.facebook.com/exemple">
                            </div>
                        </div>
                        <div class="media fb-box">
                            <div class="media-left fb-icon">
                                <i class="icon-facebook"></i>
                                <i class="icon-ok"></i>
                                <i class="icon-cancel"></i>
                                <i class="icon-spin5 animate-spin"></i>
                            </div>
                            <div class="media-body fb-inner">
                                <label class="fb-nb" for="fb_page_2">Second page</label>
                                <input name="accounts[]" id="fb_page_2" class="fb-input" type="text" name="fb_page_2" placeholder="https://www.facebook.com/exemple">
                            </div>
                        </div>
                    </div>

                    <div class="fb-footer clearfix">
                        <button class="mbtn mbtn-icon next-btn" id="nextStep" disabled aria-controls="date-tab" role="tab" data-toggle="tab">
                            <span>Next</span>
                            <i class="b-angle-right"></i>
                            <i class="icon-spin5 animate-spin"></i>
                        </button>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane period-tab fade in" id="date-tab">
                    <div class="fb-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <label>
                                    Benchmark Name
                                </label>
                                <div class="input-container">
                                    <input class="form-control" id="title" type="text" name="title" placeholder="Benchmark">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>Choose the time periods for your benchmark report.</p>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    Since
                                </label>
                                <div class="input-container">
                                    <input class="form-control datepicker" id="date-from" type="text" name="since" placeholder="12/09/2017" value="{{ Carbon\Carbon::now()->subDays(9)->toDateString() }}">
                                    <i class="b-calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    Until
                                </label>
                               <div class="input-container">
                                    <input class="form-control datepicker" id="date-to" type="text" name="until" placeholder="12/12/2017" value="{{ Carbon\Carbon::yesterday()->toDateString() }}">
                                    <i class="b-calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-6" id="difTime">
                                <span>Benchmark 8 Days</span>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong class="price">5 USD</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                VAT
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong>0 USD</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <strong>TOTAL</strong>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <strong class="price">5 USD</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fb-footer clearfix">
                        <script
                          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                          data-key="{{ env('STRIPE_KEY') }}"
                          data-amount="500"
                          data-name="Benchmarks.digital"
                          data-panel-label="PAY"
                          data-label="Generate"
                          data-email="{{ auth()->user()->getValidEmail() }}"
                          data-image="{{ url('/images/logo.jpg') }}"
                          data-locale="auto"
                          data-zip-code="false"
                          data-currency="usd">
                        </script>
                         <script>
                            document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
                        </script>
                        <div class="fb-footer-inner">
                            <button id="initStripe" type="submit"  class="hidden" waves-hover></button>
                            <button type="submit" id="generateBench" class="mbtn">
                                <span>Purchase</span>
                            </button>
                        </div>
                        <a id="backBtn" class="mbtn mbtn-default mbtn-icon prev-btn" href="#fb-tab" aria-controls="fb-tab" role="tab" data-toggle="tab">
                            <i class="b-angle-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    @endif
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalConfirm">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete this benchmark permanently, Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-id="" id="ConfirmYes">Yes</button>
                <button type="button" class="btn btn-default" id="ConfirmNo">No</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
var form;
var mainButton = $("#nextStep");

ga('send', {
  hitType: 'pageview',
  title: 'Listing page',
  page: '/home',
});
$( "#backBtn" ).click(function() {
  mainButton.removeClass('loading');
});
$(document).ready(function() {
    var searchIcon = '<i class="b-search"></i>';

    $('#listing-table').DataTable({
        paging: true,
        pagingType: "full_numbers",
        ordering: true,
        bLengthChange: false,
        info: false,
        searching: true,
        scrollX: true,
        language: {
            search: searchIcon,
            searchPlaceholder: "Search...",
            paginate: {
                first:      '<i class="icon-angle-double-left"></i>',
                last:       '<i class="icon-angle-double-right"></i>',
                previous:   '<i class="icon-angle-left"></i>',
                next:       '<i class="icon-angle-right"></i>'
            },
        }
    });

    $(document).on('click', '.table-delete', function (e) {
        $("#modalConfirm").modal('show');
        $('#ConfirmYes').data('id', $(this).data('id'));
    });
    $('#ConfirmNo').unbind('click').bind('click', function (e) {
        $('#ConfirmYes').data('id', '');
        $("#modalConfirm").modal('hide');
    });
    $('#ConfirmYes').unbind('click').bind('click', function (e) {
        deleteBenchmark($(this).data('id'));
        $('#ConfirmYes').data('id', '');
        $("#modalConfirm").modal('hide');
    });

    function deleteBenchmark(bench_id)
    {
        ga('send', 'event', 'ListingPage', 'DeleteBenchmark', 'Deleted Benchmark');
        fbq('trackCustom', 'DeletedBenchmark');
        $.post('/benchmarks/delete', { id: bench_id }).then(function(response){
            if(response.status == 1){
                showAlert('success','Benchmark deleted successfully',5);
                $('#listing-table').DataTable().row( $('#benchmark-'+bench_id) ).remove().draw();
                return true;
            } else {
                showAlert('danger','Something went wrong, Try again',5);
                return false;
            }
            return false;
        });
    }
});


$("#nextStep").unbind('click').bind("click", function (event) {
    var fbBox = $('.fb-box');
    event.preventDefault();
    fbBox.removeClass('error');
    fbBox.removeClass('success');
    fbBox.removeClass('loading');

    var count = fbBox.filter(function () {
        return $(this).children('.fb-inner').children('.fb-input').val() != '';
    }).addClass('loading');
    var dupls = inputsHaveDuplicateValues();

    if (!inputsHaveDuplicateValues()) {
        mainButton.addClass('loading');
    } else {
        $('.fb-box').removeClass('loading');
        fbBox.filter(function () {
            var val = $(this).children('.fb-inner').children('.fb-input').val();
            if (val == '') {
                return false;
            }
            return dupls.includes(val);
        }).addClass('error');
        showAlert('danger', "Can't add duplicate pages", 5);
        return false;
    }

    form = $('#submit_pages');
    var pages = $('#submit_pages').serializeArray();

    $.ajax({
        url: '/api/pages/validate',
        type: 'post',
        statusCode: {
            422: function (response) {
                $('.fb-box').removeClass('loading');
                $('.fb-box').addClass('success');
                $.each(response.responseJSON.errors, function (key, value) {
                    var index = key.split(".");
                    $('#f_' + index[1]).closest("div.fb-box").removeClass('success').addClass('error');
                });
                $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');
                mainButton.removeClass('loading');
            }
        },
        data: pages,
        success: function (data) {
            $('.fb-box').removeClass('loading');
            $('.fb-box').addClass('success');
            $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');

            if (data.hasOwnProperty('min')) {
                showAlert('danger', 'Two Facebook pages required at least', 5);
                mainButton.removeClass('loading');
                return false;
            }
            if (data.hasOwnProperty('pages')) {

                $.each(data.pages, function (index, value) {
                    $('#f_' + index).closest("div.fb-box").removeClass('success').addClass('error');
                });
                mainButton.removeClass('loading');
                showAlert('danger', "These pages dosen't exist", 5);
                return false;
            }
            if (data.hasOwnProperty('success')) {

                ga('send', 'event', 'GeneratingFreeBenchmark', 'AddedFreeBenchmark', 'Free benchmark generating started');
                fbq('trackCustom', 'FreeBenchmark', 'Freebenchmark added');

                $.each(data.ids, function (key, value) {
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "account_ids[]")
                        .attr('value', value)
                        .appendTo(form);
                });
                event.preventDefault();
                nextStep();
            }
        },
        error: function (data) {
            console.log(data.responseJSON);
        }
    });
});

function nextStep()
{
    $('#fb-tab-li').addClass('success');
    $('#date-tab-li').addClass('active');
    $('#fb-tab').removeClass('active');
    $('#date-tab').addClass('active in');
}
$("#generateBench").unbind('click').bind("click", function (e) {
    if($('#title').val().length < 4){
        $(this).attr('disabled',false);
        $(this).removeClass('loading');
        showAlert('danger','Title is too short',5);
        return false;
    }

    var since = new Date($('#date-from').val());
    var until = new Date($('#date-to').val());
    if(until < since){
        showAlert('danger','Invalid date range',5);
        return false;
    }
    if(timeDiff(since,until) < 8){
        sendForm();
        $(this).attr('disabled',false);
        $(this).removeClass('loading');
        return false;
    } else {
        $('#initStripe').click();
        return false;
    }


    e.preventDefault();
    sendForm();
});

function sendForm(){
    ga('send', 'event', 'ListingPage', 'CreatedBenchmark', 'Created benchmark from listing page');
    fbq('trackCustom', 'CreatedBenchmarkListing');
    $.ajax({
        url: '/benchmark/new-bench',
        type: 'post',
        data: $('#submit_pages').serializeArray(),
        statusCode: {
            422: function (response) {
                showAlert('danger','Invalid date range',5);
                return false;
            }
        },
        success: function (data) {
            $("#generateBench").attr('disabled',false);
            $("#generateBench").removeClass('loading');

            if(data.status == 0){
                showAlert('error',data.msg,5);
                return false;
            }

            window.location.href = '/benchmarks/' + data.id;
            return false;
        },
        error: function (data) {
            $("#generateBench").attr('disabled',false);
            $("#generateBench").removeClass('loading');
        },
    });

}

$(document).on('focusout','.fb-input',function(){
        validatePage($(this));
});

function validatePage(url){
    if(url.val() == ''){
        return false;
    }

    var input = {accounts : [url.val()]};
    var fbBox = $('.fb-box');

    fbBox.removeClass('error');

    $('#nextStep').prop('disabled',true);

    url.parent().parent().addClass('loading');
    $.ajax({
        url: '/api/pages/validate/single',
        type: 'post',
        data: input,
        success: function (data) {
            var dupls = inputsHaveDuplicateValues();
            if(!inputsHaveDuplicateValues()){
               } else {
                $('#nextStep').prop('disabled',true);
                    fbBox.filter(function(){
                        var val = $(this).children('.fb-inner').children('.fb-input').val();
                        if(val == ''){
                            return false;
                        }
                        return dupls.includes(val);
                    }).removeClass('success').removeClass('loading').addClass('error');
                    showAlert('danger',"Can't add duplicate pages",5);
                    return false;
                }
            if(data.status == 1){

                var count = fbBox.filter(function(){
                        var val = $(this).children('.fb-inner').children('.fb-input').val();
                        if(val == ''){
                            return false;
                        }
                        count += 1;
                        return val;
                }).length;
                if(count>1){
                  $('#nextStep').prop('disabled',false);
                }

                url.parent().parent().removeClass('loading').addClass('success');
            } else {
                $('#nextStep').prop('disabled',true);
                 url.parent().parent().removeClass('success').removeClass('loading').addClass('error');
            }
        },
        error: function (data) {
            $('#nextStep').prop('disabled',true);
            showAlert('warning','Something went wrong',6);
        },
    });
}

function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return value;
        }
        valuesSoFar[value] = true;
    }
    return false;
}
function inputsHaveDuplicateValues() {
  var arr = [];
  $('.fb-box').each(function () {
    arr.push($(this).children('.fb-inner').children('.fb-input').val());
  });
  var elem = hasDuplicates(arr);
  if(!elem){
    return false;
  }
  return elem;
}
</script>



<script type="text/javascript">
var since = new Date();
var statuss = {!! json_encode($hasBenchmarks) !!}
since.setDate(since.getDate() - 2);
var until = new Date();
until.setDate(until.getDate() - 1);
$( document ).ready(function() {
    var input_from = $('#date-from').pickadate({
            showMonthsShort: true,
            close: 'Cancel',
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            format: 'yyyy-mm-dd',
            max: since,
    });
    var input_to = $('#date-to').pickadate({
            showMonthsShort: true,
            close: 'Cancel',
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            format: 'yyyy-mm-dd',
            max: until,
    });
    input_from = input_from.pickadate('picker');
    input_to = input_to.pickadate('picker');

    if(statuss > 0){
            input_from.on({
      set: function(e) {
       if(e.select){
        valideDates();
       }
      }
    });
    input_to.on({
      set: function(e) {
       if(e.select){
        valideDates();
       }
      }
    });
    }

});


function valideDates(){
    $('#hideme').attr('disabled',true);
    $('.price').html('0 USD');
    $('#difTime').html('<span>Benchmark 7 Days</span>');

    if($('#date-from').val() == '' || $('#date-to').val() == ''){
        showAlert('danger','Invalid date range',6);
        return false;
    }
    var since = new Date($('#date-from').val());
    var until = new Date($('#date-to').val());
    if(until < since){
        showAlert('danger','Invalid date range',6);
        return false;
    }
    if(timeDiff(since,until) < 8){
        $('.price').html('0 USD');
        return false;
    }
    var diff = timeDiff( $('#date-from').val(), $('#date-to').val() );
    $('#difTime').html('<span>Benchmark '+diff+' Days</span>');
    $('.price').html('5 USD');
    $('#hideme').attr('disabled',false);
    return true;
}

</script>

@endsection
