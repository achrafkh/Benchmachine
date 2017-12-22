@extends('layouts.master')
@section('content')
@include('layouts.partials.pixels')
@include('layouts.partials.header')
@include('layouts.partials.sidebar')


@include('layouts.partials.loader')


@endsection
@section('custom-js')
<script type="text/javascript">
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
$('.print-btn').unbind('click').bind('click', function (e) {
  ga('send', 'event', 'BenchmarkPage', 'Download', 'Benchmark downloaded');
  fbq('trackCustom', 'BenchmarkDownload');
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
	$('#emailError').text('');
	$('#emailError').css('display','none');
	$.ajax({
	        type:"POST",
	        data: {email: $('#email').val()},
	        url: '/email-edit',
	        success: function(data){
	          if(data.code == 0){

	          	ga('send', 'event', 'Loading', 'EmailUpdate', 'Successfully Updated Email');
                fbq('trackCustom', 'EmailUpdate','{status: "success"}');

	          	$('#emailError').text(data.msg);
	          	$('#emailError').addClass('alert-danger');
	          	$('#emailError').slideDown("slow").css('display','block');
	          } else {
	          	$('#emailError').text(data.msg);
	          	$('#emailError').addClass('alert-success');
	          	$('#emailError').slideDown("slow").css('display','block');
	          }
	         	$("#emailError").fadeTo(5000, 500).slideUp(500, function(){
			    	$("#emailError").slideUp(500);
				});
	        }
	    });
	});
</script>
@endsection
