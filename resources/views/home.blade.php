@extends('layouts.master')
@section('content')

@include('layouts.partials.header',['hidden_sidebar' => true])

<div class="listing-wrapper">
    <div class="listing-inner">
        <div class="container">
            <h1 class="page-title">
            My Benchmarks
            </h1>
           @if($benchmarks->count())
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
                        <td>
                            <button  class="table-delete" data-id="{{ $benchmark->id }}">
                            <svg class="svg" role="img" title="trash">
                                <use xlink:href="assets/images/svg-icons.svg#icon-trash"/>
                            </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           @endif
        </div>
    </div>
        <div class="fb-wrapper">
        <div class="fb-inner">
            <div class="fb-header">
                <h1>
                    Make another <b>benchmark.</b>
                </h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <svg class="svg svg-tab-icon" role="img" title="clipboard">
                        <use xlink:href="assets/images/svg-icons.svg#icon-clipboard"/>
                    </svg>
                    <span>Add Pages</span>
                    <svg class="svg svg-tab-success" role="img" title="round-check">
                        <use xlink:href="assets/images/svg-icons.svg#icon-round-check"/>
                    </svg>
                    <svg class="svg svg-tab-next" role="img" title="angle-right">
                        <use xlink:href="assets/images/svg-icons.svg#icon-angle-right"/>
                    </svg>
                </li>
                <li role="presentation">
                    <svg class="svg svg-tab-icon" role="img" title="calendar">
                        <use xlink:href="assets/images/svg-icons.svg#icon-calendar"/>
                    </svg>
                    <span>Select Periode</span>
                    <svg class="svg svg-tab-success" role="img" title="round check">
                        <use xlink:href="assets/images/svg-icons.svg#icon-round-check"/>
                    </svg>
                    <svg class="svg svg-tab-next" role="img" title="angle right">
                        <use xlink:href="assets/images/svg-icons.svg#icon-angle-right"/>
                    </svg>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="fb-tab">
                    <div class="fb-header">
                        <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
                    </div>
                    <form class="fb-form">
                        <div class="fb-form-inner">
                            <div class="media fb-box">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-ok"></i>
                                    <i class="icon-cancel"></i>
                                    <i class="icon-spin5 animate-spin"></i>
                                </div>
                                <div class="media-body fb-inner">
                                    <label class="fb-nb" for="fb_page_1">First page</label>
                                    <input id="fb_page_1" class="fb-input" type="text" name="fb_page_1" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                            <div class="media fb-box">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                </div>
                                <div class="media-body fb-inner">
                                    <label class="fb-nb" for="fb_page_2">Second page</label>
                                    <input id="fb_page_2" class="fb-input" type="text" name="fb_page_2" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="fb-footer">
                        <a class="mbtn" href="#date-tab" aria-controls="date-tab" role="tab" data-toggle="tab">
                            <span>Next Step</span>
                        </a>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="date-tab">

                </div>

            </div>
        </div>
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
ga('send', {
  hitType: 'pageview',
  title: 'Listing page',
  page: '/home',
});
$(document).ready(function() {
    var searchIcon = '\
        <svg class="svg" role="img" title="search">\
            <use xlink:href="assets/images/svg-icons.svg#icon-search"/>\
        </svg>'

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

    $('.table-delete').unbind('click').bind('click', function (e) {
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
</script>


@endsection
