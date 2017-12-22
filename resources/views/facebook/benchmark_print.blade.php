@extends('layouts.master')
@section('content')

<link rel="stylesheet" type="text/css" href="/css/print.css">
<div class="benchmark-page">
	@if(!isset($static))
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	@endif
	@include('facebook.sections.summary_print',['averages' => $benchmark->averages,'variations' => $benchmark->variations])

	@include('facebook.sections.table_print', ['accounts' => $benchmark->accounts])


	@foreach($benchmark->charts as $test => $pack)
	 @include('facebook.sections.charts_print',['charts' => $pack])
	@endforeach

	<div class="section posts-section" >
		<div class="container">
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'likes' ])
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'comments' ])
		</div>
	</div>
	<div class="section posts-section">
		<div class="container">
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'shares' ])
			@include('facebook.sections.posts_print',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
		</div>
	</div>
	<div class="section posts-section">
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
	var col = 1;
	var type = "desc";
</script>
<script type="text/javascript" src="/assets/js/benchmark-vendors.min.js"></script>
@foreach(collect($benchmark->charts)->collapse() as $chart)
	@include('facebook.charts.print.'.$chart['type'], $chart)
@endforeach

@if(isset($data['col']) && isset($data['type']))
<script type="text/javascript">
col = {!! json_encode($data['col']) !!};
type = {!! json_encode($data['type']) !!};
</script>
@endif
<script type="text/javascript">
$('#dt-tbl').DataTable({
		"paging":   false,
		"searching": false,
        "info":     false,
        "autoWidth": false,
        "order": [[ col, type ]]
});

</script>
@endsection
