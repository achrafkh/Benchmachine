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
		<style type="text/css">
			.btn2{
				margin :0px !important;
				border-radius: 50% !important;
  				box-shadow: none !important;
  				border-radius:0!important;
			}
			.chart-cap{
				display: inline-block!important;
			}
		</style>
		<div class="row nm-7">
			@foreach(collect($benchmark->charts)->collapse() as $chart)
			<div class="{{ $chart['class'] }} p-h-7">
				<div class="chart">
					<div class="chart-content">
						<div style="margin-bottom: 5px;">
							<h3 class="chart-cap"> {{ $chart['title'] }} </h3>
							@if($chart['type'] == 'line')
							<div class="pull-right" class="btn-group" role="group" >
								<button type="button" class="btn btn2 btn-default {{ $chart['id'] }}" value="1">Days</button>
								<button type="button" class="btn btn2 btn-default {{ $chart['id'] }}" value="7">Weeks</button>
								<button type="button" class="btn btn2 btn-default {{ $chart['id'] }}" value="30">Months</button>
							</div>
							@endif
						</div>
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
			</div>
			@endforeach
		</div>
	</div>
</div>
