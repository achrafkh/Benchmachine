@extends('layouts.master')
@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')
@include('layouts.partials.loader')

@endsection
@section('custom-js')
<script type="text/javascript">

ga('send', {
  hitType: 'pageview',
  title: 'Loading Page'
  page: '/benchmarks/loading'
});

var benchId = {!! json_encode($benchmark->id) !!};

$( document ).ready(function() {
	function recursive_ajax(){
	    $.ajax({
	        type:"POST",
	        data: {pages_ids: {!! json_encode($benchmark_ids) !!} },
	        url: {!! json_encode(env('CORE').'/platform/check-pages') !!},
	        success: function(data){
	            if(data.status == 0){
	            	setTimeout(recursive_ajax, 8000);
	            } else {
	            	ga('send', 'event', 'Loading', 'Loading page', 'Completed waiting on loading page');
                    fbq('trackCustom', 'Loading','{status: "completed"}');
	            	window.location.reload();
	            }
	        }
	    });
	}
	recursive_ajax();
});

$('#mail_notif').unbind('click').bind('click', function (e) {
	if($(this).is(":checked")){
		$('#email').prop('disabled', false);
		$('#saveEmail').prop('disabled', false);
	} else {
		$('#email').prop('disabled', true);
		$('#saveEmail').prop('disabled', true);
	}
});
$('#saveEmail').unbind('click').bind('click', function (e) {
	e.preventDefault();
	$.ajax({
	        type:"POST",
	        data: {email: $('#email').val()},
	        url: '/email-edit',
	        success: function(data){
	          if(data.code == 0){
                showAlert('danger',data.msg,5);
	          } else {
	          	ga('send', 'event', 'Loading', 'EmailUpdate', 'Successfully Updated Email');
                fbq('trackCustom', 'EmailUpdate','{status: "success"}');
                showAlert('success',data.msg,5);
	          }

	        }
	    });
	});
</script>
@endsection
