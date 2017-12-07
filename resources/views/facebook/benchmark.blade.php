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
@include('payment.'.getPaymentProvider())
@endif
@endsection
@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js"></script>
<script type="text/javascript" src="/js/animate.js"></script>
@include('payment.'.getPaymentProvider().'_js')
@endsection
