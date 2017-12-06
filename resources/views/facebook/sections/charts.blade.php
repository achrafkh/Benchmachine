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
