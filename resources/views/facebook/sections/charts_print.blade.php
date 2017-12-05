<div class="section charts-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
			Charts
			</h2>
			<span class="section-cap">
				Benchmark overview
			</span>
		</div>
		<div class="row charts-wrap ">
			@foreach(collect($benchmark->charts)->collapse() as $chart)
			@if($chart['id'] != "canvas-large_line")
			<div class="{{ $chart['class'] }} chart " style="max-width: 50%;display: inline-block;">
			@else
			<div class="{{ $chart['class'] }} chart" style="max-width: 100%;display: inline-block;">
			@endif
				<div class="chart-content">
					<h3 class="chart-cap"> {{ $chart['title'] }} </h3>
					@if($chart['id'] != "canvas-large_line")
					<div style="width: 620px; height: 370px;">
						<canvas width="620" height="350" style="width: 620px; height: 350px;" id="{{ $chart['id'] }}"></canvas>
					</div>
					@else
					<div style="width: 1270px; height: 370px;">
						<canvas width="1270" height="350" style="width: 1270px; height: 350px;" id="{{ $chart['id'] }}"></canvas>
					</div>
					@endif
				</div>
				<ul class="chart-stats">
					<li>
						<span class="chart-stats-digit">1199982</span>
						<span class="chart-stats-cap">Total</span>
					</li>
					<li>
						<span class="chart-stats-digit">149997.75</span>
						<span class="chart-stats-cap">Average</span>
					</li>
				</ul>
			</div>
			@endforeach
		</div>
	</div>
</div>
@section('js')
	@foreach($benchmark->charts['bar'] as $chart)
		@include('facebook.charts.print.bar',$chart)
	@endforeach
	@foreach($benchmark->charts['pie'] as $chart)
		@include('facebook.charts.print.pie',$chart)
	@endforeach
	@foreach($benchmark->charts['grouped_bar'] as $chart)
		@include('facebook.charts.print.grouped_bar',$chart)
	@endforeach
	@foreach($benchmark->charts['line'] as $chart)
		@include('facebook.charts.print.line',$chart)
	@endforeach
@endsection
