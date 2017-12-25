@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
<div class="benchmark-page">
<?php
$freeBench = ($benchmark->details->since->diffInDays($benchmark->details->until));
?>
	@if(!isset($static))
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	@endif
  @include('layouts.partials.sidebar')
  @include('layouts.partials.breadcumbs',['page' => ($benchmark->details->title .' | Since :'. $benchmark->details->since->todateString() .' | Until :'. $benchmark->details->until->todateString()) ])
	<div class="benchmark-name" data-aos="fade-up" data-aos-once="true" data-aos-duration="800" data-aos-delay="0" data-aos-offset="0">
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

  @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'likes','sort_title' => 'Most Liked' ])
  @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'comments','sort_title' => 'Most Commented' ])
  @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'shares','sort_title' => 'Most Shared' ])
  @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate','sort_title' => 'Most Engaged' ])
  @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions','sort_title' => 'TOP posts by interactions' ])

@if(!isset($print))
@include('payment.'.getPaymentProvider())
@endif
@endsection
@section('custom-js')
@if(!isset($print))
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/assets/js/benchmark-vendors.min.js"></script>
<script type="text/javascript" src="/js/animate.js"></script>
<script type="text/javascript">
var diffIn = {!! json_encode($freeBench) !!};

var bench_id = {!! json_encode($benchmark->details->id) !!};
$( document ).ready(function() {
$.get( "/api/show-modal/"+bench_id, function( data ) {
	if(data == 1){
		$('#myModalNorm').modal('show');
	}
});
    AOS.init({
      offset: 100,
      duration: 1000,
      easing: 'ease-in-sine',
      delay: 100,
    });
});
</script>

@include('payment.'.getPaymentProvider().'_js')
@endif
<script type="text/javascript">
ga('send', {
  hitType: 'pageview',
  title: 'Benchmark Page'
  page: '/benchmarks'
});

var benchStatus = 'free';
if(diffIn > 7){
  benchStatus = 'paid';
}
  var othercharts = [];
  var charts = [];
</script>
@foreach(collect($benchmark->charts)->collapse() as $chart)
	@include('facebook.charts.'.$chart['type'], $chart)
@endforeach


<script type="text/javascript">
var gaSend = true;
$(window).scroll(function() {
    if(elementInViewport(document.getElementById("paymentStripe"))){
      if(gaSend){
          ga('send', 'event', 'BenchmarkPage', 'ScrolledToBottom', 'Scrolled to bottom of benchmark');
          fbq('trackCustom', 'ScrolledToBottom','{content_ids:"'+bench_id+'",content_type:"'+benchStatus+'"}');
          gaSend = false;
      }
    }
});

ga('send', 'event', 'BenchmarkPage', benchStatus+' Benchmark Viewed', 'Benchmark Viewed');
fbq('track', 'ViewContent','{content_ids:"'+bench_id+'",content_type:"'+benchStatus+'"}');

var order = null;
$('#table').on('order.dt', function () {
  order = $('#table').dataTable().fnSettings().aaSorting[0];
  $('#col').val(order[0]);
  $('#type').val(order[1]);
});

$('.canvas-engagment').unbind('click').bind('click', function (e) {
  $('#chartdate_en').val($(this).val());
  $('.canvas-engagment').removeClass("btn-sunny").addClass("btn-default");
  $(this).removeClass("btn-default").addClass("btn-sunny");
  $.post( "/api/update-eng",  {periode: $(this).val() ,id: {!! json_encode($benchmark->details->id)  !!}} ,function(e) {

  })
  .done(function(e) {
    var chartObject = charts[0];
    chartObject.data.datasets = e.output;
    chartObject.data.labels = e.lables;
    chartObject.update();
  })
  .fail(function(e) {
    console.log(e);
    console.log('Something went wrong');
  })
});
$('.canvas-interactions').unbind('click').bind('click', function (e) {
  $('#chartdate_in').val($(this).val());
  $('.canvas-interactions').removeClass("btn-sunny").addClass("btn-default");
  $(this).removeClass("btn-default").addClass("btn-sunny");
  $.post( "/api/update-int",  {periode: $(this).val() ,id: {!! json_encode($benchmark->details->id)  !!}} ,function(e) {

  })
  .done(function(e) {
    var chartObject = charts[1];
    chartObject.data.datasets = e.output;
    chartObject.data.labels = e.lables;
    chartObject.update();
  })
  .fail(function(e) {
    console.log(e);
    console.log('Something went wrong');
  })
});

$('.print-btn').unbind('click').bind('click', function (e) {
  ga('send', 'event', 'BenchmarkPage', 'Download', 'Benchmark downloaded');
  fbq('trackCustom', 'BenchmarkDownload');
});
$('.notif-input').unbind('click').bind('click', function (e) {
  ga('send', 'event', 'Loading', 'EmailUpdate', 'Updated Email');
  fbq('trackCustom', 'EmailUpdate');
});
$('#hideme').unbind('click').bind('click', function (e) {
  var title = {!! json_encode($benchmark->details->title) !!};
  var benchiId = {!! json_encode($benchmark->details->id) !!};
  ga('send', 'event', 'Checkout', 'InitiateCheckout', 'Presset Checkout Button');
  fbq('track', 'InitiateCheckout','{value:"5", currency:"USD", content_name:"'+title+'", content_ids:"'+benchiId+'"}');
});


</script>

@endsection
