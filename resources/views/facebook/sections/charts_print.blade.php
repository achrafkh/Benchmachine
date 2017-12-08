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
			@foreach($charts as $chart)
			@if($chart['id'] != "canvas-large_line")
			<div class="{{ $chart['class'] }} chart">
			@else
			<div class="{{ $chart['class'] }} chart">
			@endif
				<div class="chart-content">
					<h3 class="chart-cap"> {{ $chart['title'] }} </h3>
					@if($chart['id'] != "canvas-large_line")
					<canvas width="620" height="300" style="width: 620px;height: 300px;" id="{{ $chart['id'] }}"></canvas>
					@else
					<canvas width="1300" height="300" style="width: 1300px;height: 300px;" id="{{ $chart['id'] }}"></canvas>
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
@endsection
