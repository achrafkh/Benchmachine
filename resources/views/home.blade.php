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

<div class="alert" role="alert" id="result"></div>


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
