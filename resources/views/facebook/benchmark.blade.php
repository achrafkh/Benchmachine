@extends('layouts.master')
@section('content')
<style type="text/css">
.stripe-button {
    color: #f8f8f8 !important;
    background-color: #FF7212!important;
    border-color: #e78a01!important;
}
.stripe-button:hover {
    color: #fff;
    background-color: #e78a01;
    border-color: #e78a01;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
<div class="benchmark-page">
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	<div class="benchmark-name">
		<div class="container">
		@if(Session::has('flash'))
		<div class="alert alert-{{ Session::get('flash')['class'] }}">
		  {!! Session::get('flash')['msg'] !!}
		</div>
		@endif
			<h2>
				<i class="icon-pencil-alt"></i>
				<span>Title</span>
			</h2>
			<input id="original" type="hidden" name="o_title" value="{{ $benchmark->details->title }}">
			<input id="title" type="text" name="title" placeholder="Benchmark" value="{{ isset($benchmark->details->title) ? $benchmark->details->title : '' }}">
		</div>
	</div>
	@include('facebook.sections.summary',['averages' => $benchmark->averages,'variations' => $benchmark->variations])
	@include('facebook.sections.table', ['accounts' => $benchmark->accounts])
	@include('facebook.sections.charts')

 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'likes' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'comments' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'shares' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ])




<hr>
<div class="container" style="width: 50%; ">
	<div class="row">
		<div class="text-center">
			<h2 style="font-size: 32px;color: #4d4d4d;">Buy another <strong>BENCHMARK</strong></h2>
		</div>
		<hr>
	</div>
	<div class="row">
		<div class="">
			<h2 style="font-size: 30px;color: #4d4d4d;margin-bottom: 10px">Select periode</h2>
			<p style="color: #a6a6a1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
		</div>
		<hr>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div id="datepicker-inline-since" class="pull-right">
				<div class="datepicker datepicker-inline">
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div id="datepicker-inline-until" class="pull-left">
				<div class="datepicker datepicker-inline">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<h2 style="font-size: 30px;color: #4d4d4d;margin-bottom: 10px;margin-top: 20px;padding-left: 15px;">Checkout</h2>
		<br>
		<div class="col-md-6">
			Benchmark 90 Days
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong>5 USD</strong>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			VAT
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong>1 USD</strong>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6">
			<strong>TOTAL</strong>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong>590 USD</strong>
			</div>
		</div>
		<p style="font-size: 13px;color: #a6a6a1;margin-top: 20px;padding-left: 15px;">*Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
	</div>
	<div class="row">
	<form style="display: none" id="hideme" action="{{ route('stripeCheckout') }}" method="POST" style="padding :10px 10px 10px 10px" class="pull-right">
		{{ csrf_field() }}
		<input type="hidden" name="benchmark_id" value="{{$benchmark->details->id}}">
		<input type="hidden" name="since" id="since">
		<input type="hidden" name="until" id="until">
		<script
		  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		  data-key="pk_test_NwBR00CRQsOdtzDqa20ztBYl"
		  data-amount="2000"
		  data-name="Benchmark Bachine"
		  data-panel-label="PAY"
		  data-label="Buy now"
		  data-email="{{ auth()->user()->getValidEmail() }}"
		  data-description="96 Day benchmark"
		  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		  data-locale="auto"
		  data-zip-code="false"
		  data-currency="eur">
		</script>
	</form>
	</div>
	<br>
</div>

@endsection
@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

var since = new Date();
since.setDate(since.getDate() - 2);
var until = new Date();
until.setDate(until.getDate() - 1);
$( document ).ready(function() {

    $('#datepicker-inline-until').datepicker({
	    todayHighlight: false,
	    inline: true,
	    endDate: until,
        useCurrent: false,
	    format: 'yyyy-mm-dd',
    }).on('changeDate', function(event){
    	$('#until').val($('#datepicker-inline-until').datepicker("getFormattedDate"));
    	valideDates();
    });
	$('#datepicker-inline-since').datepicker({
	    todayHighlight: false,
	    inline: true,
	    endDate: since,
        useCurrent: false,
	    format: 'yyyy-mm-dd'
    }).on('changeDate', function(event){
    	$('#since').val($('#datepicker-inline-since').datepicker("getFormattedDate"));
    	valideDates();
    });
});
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
	var original = $('#original').val()
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


function valideDates(){
	$('#hideme').css('display','none');

	if($('#since').val() == '' || $('#until').val() == ''){
		return false;
	}
	var since = new Date($('#since').val());
	var until = new Date($('#until').val());
	if(until < since){
		return false;
	}
	if(timeDiff(since,until) < 8){
		return false;
	}

	$('#hideme').css('display','block');
	return true;
}
</script>
@endsection
