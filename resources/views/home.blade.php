@extends('layouts.master')
@section('content')
@include('layouts.partials.header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<style type="text/css">
footer{
     bottom: 0;
    position: fixed;
    width: 100%;
}

#DataTables_Table_0_filter > label > input[type="search"] {
    border-style: inset;
    border-width: thin;
}
#DataTables_Table_0_length > label > select {
    background-color: white;
}
</style>
<div class="container" style="padding: 50px">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" >
                <!-- <div class="panel-heading">Benchmarks
                    <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal">New</button>
                </div> -->
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="span5" style="padding: 10px">
                            <table class="table table-striped table-condensed datatables" >
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date Created</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th class="no-sort">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($benchmarks as $benchmark)
                                    <tr>
                                        <td>{{ $benchmark->title }}</td>
                                        <td>{{ $benchmark->created_at }}</td>
                                        <td>{{ $benchmark->since }}</td>
                                        <td>{{ $benchmark->until }}</td>
                                        <td><span class="label label-{{ $benchmark->getStatus()['class'] }}">
                                       {{ $benchmark->getStatus()['text'] }}</span></td>
                                        <td>
                                        @if($benchmark->status == 0 && isset($benchmark->order))
                                        <form class="inline pay-form" action="payment/pay/{{ $benchmark->order->id }}" data-id="{{ $benchmark->order->id }}" method="POST" style="">
                                             {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm" >Pay</button>
                                        </form>
                                        @endif
                                            <a class="btn btn-primary btn-sm" target="_blank"
                                            href="@if($benchmark->status == 2) /benchmarks/{{ $benchmark->id }}  @else javascript::void(0) @endif" @if($benchmark->status != 2) disabled  @endif >View</a>
                                            {{--
                                                <a class="btn btn-primary btn-sm" target="_blank" href="@if($benchmark->status == 2) /benchmarks/download/{{ $benchmark->id }} @else javascript::void(0) @endif"
                                            @if($benchmark->status != 2) disabled  @endif >Download</a>
                                            --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
{{--
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Benchmark</h4>
            </div>
            <div class="modal-body">
                <div class="home-form">
                    <form id="submit_pages" action="{{ route('newBench') }}" method="POST" >
                        {{ csrf_field() }}
                        <input required="" id="email" class="mail-input" type="hidden" name="email" value="{{ auth()->user()->getValidEmail() }}" >
                        <div class="hf-header">
                            <h2>
                            Add facebook pages
                            </h2>
                            <p>
                                Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.
                            </p>
                            <div id="min" class="alert alert-danger" style="display: none">
                                <strong>Danger!</strong> Minimum : 2 pages.
                            </div>
                        </div>
                        <div style="padding: 10px" class="row">
                            <input class="col-md-6" type="date" name="since">
                            <input class="col-md-6" type="date" name="until">
                        </div>
                        <div class="fb-wrap">
                            <div class="media fb-box focused">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                </div>
                                <div id="f_0" class="media-body fb-inner error_c">
                                    <h4 class="fb-nb">First page</h4>
                                    <input id="fb_page_0" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                            <div class="media fb-box">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                </div>
                                <div id="f_1" class="media-body fb-inner error_c">
                                    <h4 class="fb-nb">Second page</h4>
                                    <input id="fb_page_1" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                        </div>
                        <div class="media mail">

                            <div class="media-right mail-submit">
                                <button class="btn btn-primary" id="trigger" type="button" waves-hover>
                                Generate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
--}}

<div class="modal fade" id="DetailsModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">My Modal</h3>
        </div>
        <div class="modal-body">

            <!-- content goes here -->
            <form id="saveDetails">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Phone number</label>
                <input type="text" class="form-control" name="phone"  placeholder="Phone">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Country</label>
                <input type="text" class="form-control" name="country"  placeholder="Country">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">City</label>
                <input type="text" class="form-control" name="city" placeholder="City">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Address</label>
                <input type="text" class="form-control" name="address"  placeholder="Address">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">address2</label>
                <input type="text" class="form-control" name="address2"  placeholder="Address 2">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Zip</label>
                <input type="text" class="form-control" name="zip" placeholder="Zip">
              </div>
              <button type="submit" class="btn btn-default btn-hover-green" role="button">Save</button>
            </form>

        </div>
        <div class="modal-footer">

        </div>
    </div>
  </div>
</div>
@endsection


@section('custom-js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.datatables').DataTable({
        columnDefs: [
          { targets: 'no-sort', orderable: false }
        ]
    });
} );
</script>

@if(!auth()->user()->hasDetails())
<script type="text/javascript">
var id = '';
var url = {!! json_encode(url('payment/pay/')) !!};

     $(".pay-form").submit(function (e) {
            e.preventDefault();
            id = $(this).data('id');
            $('#DetailsModal').modal('show');
     });
     $("#saveDetails").submit(function (e) {
            e.preventDefault();
            $.post( "/api/details", $(this).serialize() , function(e){
                if(e.status == 0){
                }
                if(e.status == 1){
                    window.location.href = url+'/'+id;
                }
            });
     });
</script>
@endif

@endsection
