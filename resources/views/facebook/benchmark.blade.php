@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css">
<div class="benchmark-page">
	@if(!isset($static))
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	@endif
	<div class="benchmark-name" data-aos="fade-up" data-aos-once="true">
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
			<input class="animated bounceInDown" data-id="1" id="title" type="text" name="title" placeholder="Benchmark" value="{{ isset($benchmark->details->title) ? $benchmark->details->title : '' }}">
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
@if(!isset($print))
<hr>
<div class="container" style="width: 50%;"  data-aos="fade-up">
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
		<div class="col-md-6" id="difTime">
			<span>Benchmark {{ $benchmark->details->since->diffInDays($benchmark->details->until) }} Days</span>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong class="price">5 USD</strong>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			VAT
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong>0 USD</strong>
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
				<strong class="price">5 USD</strong>
			</div>
		</div>
		<p style="font-size: 13px;color: #a6a6a1;margin-top: 20px;padding-left: 15px;">*Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
	</div>
	<style type="text/css">
.btn-sunny {
color: #fff;
background-color: #f4ad49;
border-bottom:2px solid #c38a3a;
}

.btn-sunny:hover, .btn-sky.active:focus, .btn-sunny:focus, .open>.dropdown-toggle.btn-sunny {
color: #fff;
background-color: #f5b75f;
border-bottom:2px solid #c4924c;
outline: none;
}
.btn-sunny:active, .btn-sunny.active {
color: #fff;
background-color: #d69840;
border-top:2px solid #ab7a33;
margin-top: 2px;
}
.btn:focus,
.btn:active:focus,
.btn.active:focus {
    outline: none;
    outline-offset: 0px;
}

a {color:#fff;}
a:hover {text-decoration:none; color:#fff;}
.btn{
    margin: 4px;
    box-shadow: 1px 1px 5px #888888;
}

.btn-xs{
    font-weight: 300;
}
	</style>
	<div class="row">
	<form   action="{{ route('stripeCheckout') }}" method="POST" style="padding :10px 10px 10px 10px" class="pull-right">
		{{ csrf_field() }}
		<input type="hidden" name="benchmark_id" value="{{$benchmark->details->id}}">
		<input type="hidden" name="since" id="since">
		<input type="hidden" name="until" id="until">
		<script
		  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		  data-key="pk_test_NwBR00CRQsOdtzDqa20ztBYl"
		  data-amount="{{config('price.usd').'00'}}"
		  data-name="Benchmark Machine"
		  data-panel-label="PAY"
		  data-label="Generate"
		  data-email="{{ auth()->user()->getValidEmail() }}"
		  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		  data-locale="auto"
		  data-zip-code="false"
		  data-currency="usd">
		</script>
		 <script>
        document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
	    </script>
	    <button type="submit"  style="display:none" id="hideme" class="btn btn-sunny text-uppercase btn-md">Proceed</button>
	</form>
	</div>
	<br>
</div>
@endif
@endsection
@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js"></script>
<script type="text/javascript" src="/js/animate.js"></script>
<script type="text/javascript">
var since = new Date();
since.setDate(since.getDate() - 2);
var until = new Date();
until.setDate(until.getDate() - 1);

$( document ).ready(function() {
	$( ".animateMe" ).each(function( index ) {
		var nbr = parseInt( $(this).text().replace(/ /g,'') , 10);
		$(this).text(0);
		 setTimeout(function() {
	        $(this).animateNumber({
	         number: nbr,
	         easing: 'easeInQuad',
	        },2000);
	    }.bind(this), 1800 + (index * 100));
	});
	AOS.init({
      offset: 600,
      duration: 1000,
      easing: 'ease-in-sine',
      delay: 500,
      disable: 'mobile',
    });
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


function valideDates(){
	$('#hideme').css('display','none');
	$('.price').html('0 USD');
	$('#difTime').html('<span>Benchmark 7 Days</span>');
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
	var diff = timeDiff( $('#since').val(), $('#until').val() );
	$('#difTime').html('<span>Benchmark '+diff+' Days</span>');
	$('.price').html('5 USD');
	$('#hideme').css('display','block');
	return true;
}

</script>
@endsection
