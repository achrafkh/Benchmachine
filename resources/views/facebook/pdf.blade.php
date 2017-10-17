@extends('layouts.master')
@section('content')
<div class="benchmark-page">
	<div class="benchmark-name">
		<div class="container">
			<h1 style="font-weight: bold;font-size: 60px">
				<span> {{ $benchmark->details->title }} </span>
			</h1>
		</div>
	</div>
	@include('facebook.sections.summary',['averages' => $benchmark->averages])
	@include('facebook.sections.table', ['accounts' => $benchmark->accounts])
	@include('facebook.sections.charts')
	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ])
</div>
@endsection
@section('js')
@include('facebook.test')
@endsection
