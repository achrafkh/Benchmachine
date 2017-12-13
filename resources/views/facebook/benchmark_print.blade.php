@extends('layouts.master')
@section('content')
<link rel="stylesheet" type="text/css" href="/css/print.css">
<style type="text/css">
@media print {
a[href]:after { content: none !important; }
</style>
<div class="benchmark-page">
	@if(!isset($static))
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	@endif
	@include('facebook.sections.summary_print',['averages' => $benchmark->averages,'variations' => $benchmark->variations])

	@include('facebook.sections.table_print', ['accounts' => $benchmark->accounts])


	@foreach($benchmark->charts as $test => $pack)
	 @include('facebook.sections.charts_print',['charts' => $pack])
	@endforeach

	<div class="section posts-section" data-aos="slide-up" data-aos-once="true">
		<div class="container">
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'likes' ])
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'comments' ])
		</div>
	</div>
	<div class="section posts-section" data-aos="slide-up" data-aos-once="true">
		<div class="container">
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'shares' ])
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
		</div>
	</div>
	<div class="section posts-section" data-aos="slide-up" data-aos-once="true">
		<div class="container">
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ])
		</div>
	</div>


@if(!isset($print))
@include('payment.'.getPaymentProvider())
@endif
@endsection
@section('custom-js')
@if(!isset($print))
@include('payment.'.getPaymentProvider().'_js')
@endif
<script type="text/javascript">
	var othercharts = [];
</script>
@foreach(collect($benchmark->charts)->collapse() as $chart)
	@include('facebook.charts.print.'.$chart['type'], $chart)
@endforeach

<script type="text/javascript">
	 function onBeforePrint(){
	 	$.each(othercharts, function( index, value ) {
		  value.resize();
		})
	 }
</script>
@endsection
