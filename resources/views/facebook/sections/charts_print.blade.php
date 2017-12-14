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
					@if($chart['type'] != "line")
					<canvas width="620" height="300" style="width: 620px;height: 300px;" id="{{ $chart['id'] }}"></canvas>
					@else
					<canvas width="1300" height="300" style="width: 1300px;height: 300px;" id="{{ $chart['id'] }}"></canvas>
					@endif
				</div>
				<ul class="chart-stats" style="min-height: 50px">
						@if(isset($chart['total']))
						<li>
						@if(number_format($chart['total'], 0, '.', ' ') == 0)
						<span class="chart-stats-digit">{{number_format($chart['total'], 3, '.', ',')  }}</span>
						@else
						<span class="chart-stats-digit">{{ number_format($chart['total'], 0, '.', ' ')  }}</span>
						@endif
							<span class="chart-stats-cap">Total</span>
						</li>
						@endif
						@if(isset($chart['avg']))
						<li>
						@if(number_format($chart['total'], 0, '.', ' ') == 0)
						<span class="chart-stats-digit">{{  number_format($chart['avg'], 3, '.', ',') }}</span>
						@else
						<span class="chart-stats-digit">{{  number_format($chart['avg'], 0, '.', ' ') }}</span>
						@endif
							<span class="chart-stats-cap">Average</span>
						</li>
						@endif
					</ul>
			</div>
			@endforeach
		</div>
	</div>
</div>
@section('js')
@endsection
