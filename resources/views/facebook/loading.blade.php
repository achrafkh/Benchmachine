@extends('layouts.master')
@section('content')

<div class="benchmark-page">
@include('layouts.partials.header')
<style>
footer{
  position: fixed;
    bottom: 0;
    width: 100%;
}
.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
.btn-labeled {padding-top: 0;padding-bottom: 0;}
.btn { margin-bottom:10px; }
.modal {
  text-align: center;
}

@media screen and (min-width: 768px) {
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="benchmark-page" id="loader" style="z-index: 200">

@if(!Session::has('email-'. $benchmark->id ))
  <div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close"
          data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">
          Get notified
          </h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <form role="form" id="change_email" method="POST" action="{{ route('editEmail') }}">
            {{ csrf_field() }}
            <div class="form-group">
            <input type="hidden" name="id" value="{{ $benchmark->id }}">
              <label for="exampleInputEmail1" style="margin-bottom: 10px">Email address</label>
              <input required="" type="email" class="form-control" name="email"
              id="email" value="{{ auth()->user()->getValidEmail() }}" placeholder="Enter email"/>
            </div>
            <button type="submit" class="btn btn-warning">save</button>
          </form>
        </div>
        <!-- Modal Footer -->
       <!--  <div class="modal-footer">
    <button type="button" class="btn btn-default"
          data-dismiss="modal">
          Close
          </button>
          <button type="button" class="btn btn-primary">
          Save changes
          </button>
        </div> -->
      </div>
    </div>
  </div>
@endif
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
$( document ).ready(function() {
  startLoader();
  $('#myModalNorm').modal('show');
	function recursive_ajax(){
	    $.ajax({
	        type:"POST",
	        data: {pages_ids: {!! json_encode($benchmark_ids) !!} },
	        url: {!! json_encode(env('CORE').'/platform/check-pages') !!},
	        success: function(data){
	            if(data.status == 0){
	            	setTimeout(recursive_ajax, 8000);
	            } else {
	            	window.location.reload();
	            }
	        }
	    });
	}
	recursive_ajax();
});
</script>
@endsection
