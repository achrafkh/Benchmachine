@extends('layouts.master')
@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')

@include('layouts.partials.loader')


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
