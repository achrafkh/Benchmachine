@extends('layouts.master')
@section('content')
<div class="home-page">
    <div class="landing">
        <div class="landing-wrap">
            <div class="landing-inner">
                <a class="landing-logo" href=".">
                    <img class="hidden-xs" alt="Benchmarks.digital logo" src="/assets/images/logo.png">
                    <svg class="svg visible-xs" role="img" title="logo">
                        <use xlink:href="/assets/images/svg-icons.svg#logo"/>
                    </svg>
                </a>
               {{--
                 @if(auth()->check())
                <a class="landing-login" href="{{ url('/home') }}" waves-hover>
                    <i class="icon-facebook"></i>
                    Connect
                </a>
                @else
                <a class="landing-login" href="{{ url('/auth/facebook') }}" waves-hover>
                    <i class="icon-facebook"></i>
                    Connect
                </a>
                @endif
               --}}
                <h1 class="landing-title">
                Get a Free Market Overview Now
                </h1>
                <p class="landing-txt">
                   Discover your key performances indicators, Learn  from social leaders and Set goals and baselines for performance and growth based on your direct competitors.
                </p>
                <a onclick="smoothScroll(document.getElementById('submit_pages'))"  href="#" id="glance" class="landing-btn white-txt" waves-hover>
                Get A Glance
                </a>
                <div class="video">
                    <div class="video-inner">
                        <video alt="video on screen" autoplay="" loop="" muted="" playsinline="" poster="{{url('/images/background2.png')}}">
                            <source src="{{ url('/assets/videos/benchmark.mp4') }}" type="video/mp4">
                            <source src="{{ url('/assets/videos/benchmark.webm') }}">
                            Your browser does not support the video tag.
                        </video>
                        <img alt="page background" class="video-screen" src="/assets/images/md-christmas-screen.png">
                    </div>
                </div>
            </div>
        </div>
        <canvas id="snow" class="snow"></canvas>
        <img alt="cloud picture" class="cloud cloud-1" src="/assets/images/cloud_1.png">
        <img alt="cloud picture" class="cloud cloud-2" src="/assets/images/cloud_2.png" >
    </div>
    <div class="fb-wrapper">
        <form id="submit_pages" action="{{ route('newDemoBench') }}" method="POST" class="fb-form">
            {{ csrf_field() }}
            <input type="hidden" name="invitation" value="{{ $invitation->id }}">
            <div class="fb-header">
                <h1>
                Make another <b>benchmark.</b>
                </h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <i class="b-clipboard"></i>
                    <span>Add Pages</span>
                </li>
                <li role="presentation">
                    <i class="b-calendar"></i>
                    <span>Select Periode</span>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fb-tab fade in active"" id="fb-tab">
                    <div class="fb-header">
                        <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
                    </div>
                    <div class="fb-inner fb-form-inner">
                        <div class="media fb-box">
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
                    <div class="fb-footer">
                        <button disabled class="mbtn" id="nextStep" aria-controls="date-tab" role="tab" data-toggle="tab">
                        <span>Next Step</span>
                        </button>
                    </div>
                </div>

                 <div role="tabpanel" class="tab-pane period-tab fade in" id="date-tab">
                    <div class="fb-header">
                        <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
                    </div>
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
                            <div class="col-md-6">
                                <label>
                                    From
                                </label>
                                <div class="input-container">
                                    <input class="form-control datepicker" id="date-from" type="text" name="since" value="{{Carbon\Carbon::now()->subDays(8)->toDateString()}}">
                                    <i class="b-calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    To
                                </label>
                               <div class="input-container">
                                    <input class="form-control datepicker" id="date-to" type="text" name="until" value="{{Carbon\Carbon::now()->subDays(1)->toDateString()}}">
                                    <i class="b-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fb-footer">
                        <button id="generateBench" class="media fb-sub" waves-hover>
                        <div class="media-left media-middle">
                            <i class="icon-facebook"></i>
                            <i class="icon-spin5 animate-spin"></i>
                        </div>
                        <div class="media-body media-middle">
                            Generate Benchmark
                        </div>
                        </button>
                        <p class="fb-sub-cap">
                            One click, No password, Simple and practical
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<input type="hidden" id="refreshed" value="no">
<input type="hidden" id="auth" value="{{ auth()->check() }}">
@endsection
@section('js')
<script type="text/javascript">
onload = function () {
    var e = document.getElementById("refreshed");
    if (e.value == "no"){
        e.value = "yes";
        ga('send', 'event', 'Invitation', 'CheckedInvitation', 'Viewed invitation');
        fbq('trackCustom', 'ClickedInvitation');
    }
    else {
        e.value = "no";
        location.reload();
    }
}
var auth = $('#auth').val();
var form;
var mainButton = $("#nextStep");
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
    $('#fb-tab').removeClass('active');
    $('#date-tab-li').addClass('active');
    $('#date-tab').addClass('active');
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


    $(this).attr('disabled',true);
    $(this).addClass('loading');
    e.preventDefault();

    sendForm();
});

function sendForm(){
    $.post('/benchmark/new', $('#submit_pages').serializeArray()).done(function (data) {
        ga('send', 'event', 'Invitation', 'CreatedBenchmark', 'Created Benchmark using an infitation');
        fbq('trackCustom', 'InvitationCreatedBenchmark');
        if (auth) {
            if(data.status == 0){
                showAlert('error',data.msg,5);
                return false
            }
            window.location.href = '/benchmarks/' + data.id;
            return false;

        } else {
            window.location.href = '/auth/facebook';
        }
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
ga('send', {
  hitType: 'pageview',
  title: 'Landing Page',
  page: '/invitation',
});
</script>

<script type="text/javascript" src="/assets/js/canvas/snow.js"></script>
<!-- <script type="text/javascript" src="/js/welcome.js"></script> -->
@endsection
