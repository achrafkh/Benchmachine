@extends('layouts.master')
@section('content')
<style type="text/css">
	@media print {
body {
   display:table;
   table-layout:fixed;
   padding-top:2.5cm;
   padding-bottom:2.5cm;
   height:auto;
    }
.brk {
    page-break-before: always;
  }
}

</style>
<div class="benchmark-page">
	<div class="benchmark-name">
		<div class="container">
			<h2>
				<i class="icon-pencil-alt"></i>
				<span>Title</span>
			</h2>
			<input id="title" type="text" name="title" placeholder="Benchmark" value="{{ $benchmark->details->title }}">
		</div>
	</div>
	@include('facebook.sections.summary',['averages' => $benchmark->averages,'variations' => $benchmark->variations])
	@include('facebook.sections.table', ['accounts' => $benchmark->accounts])
	@include('facebook.sections.charts_print')

 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'likes' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'comments' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'shares' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ])
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
function throttle(f, delay){
var timer = null;
	return function(){
	    var context = this, args = arguments;
	    clearTimeout(timer);
	    timer = window.setTimeout(function(){
	        f.apply(context, args);
	    },
	    delay || 1200);
	};
}
$('#title').focusout(throttle(function(e){
	var original = $('#original').val();
	if(original === $(this).val()){
		return false;
	}
	var inputVal = document.getElementById("title");
	if($(this).val().length < 5){

    	inputVal.style.borderColor = '#ED1C24';
    	return false;
	} else {
    	inputVal.style.borderColor = '#ECEBEB';
    }
	$.post( "/api/benchmarks/update-title", { title: $(this).val() ,id : {!! json_encode($benchmark->details->id) !!} })
	.done(function( data ) {
    	if(data.msg == 'error'){
    		inputVal.style.borderColor = '#ED1C24';
    	} else {
    		inputVal.style.borderColor = '#ECEBEB';
    	}
  	});
}));
</script>
@endsection
