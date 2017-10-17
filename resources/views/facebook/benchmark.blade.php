@extends('layouts.master')
@section('content')
<div class="benchmark-page">
	 @include('layouts.partials.header')
	<div class="benchmark-name">
		<div class="container">
			<h2>
				<i class="icon-pencil-alt"></i>
				<span>Title</span>
			</h2>
			<input type="text" name="" placeholder="Benchmark" value="{{ isset($benchmark->details->title) ? $benchmark->details->title : '' }}">
		</div>
	</div>
	@include('facebook.sections.summary',['averages' => $benchmark->averages])
	@include('facebook.sections.table', ['accounts' => $benchmark->accounts])
	@include('facebook.sections.charts')
	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
	{{-- @include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ]) --}}
</div>
@endsection
@section('js')
@include('facebook.test')
@endsection
