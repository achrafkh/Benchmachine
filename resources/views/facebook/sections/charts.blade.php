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
		<div class="row charts-wrap">
			@foreach(collect($benchmark->charts)->collapse() as $chart)
			<div class="{{ $chart['class'] }} chart">
				<div class="chart-content">
					<h3 class="chart-cap"> {{ $chart['title'] }} </h3>
					<canvas id="{{ $chart['id'] }}"></canvas>
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
		@include('facebook.charts.bar',$chart)
	@endforeach
	@foreach($benchmark->charts['pie'] as $chart)
		@include('facebook.charts.pie',$chart)
	@endforeach
	@foreach($benchmark->charts['grouped_bar'] as $chart)
		@include('facebook.charts.grouped_bar',$chart)
	@endforeach
	@foreach($benchmark->charts['line'] as $chart)
		@include('facebook.charts.line',$chart)
	@endforeach
@endsection
