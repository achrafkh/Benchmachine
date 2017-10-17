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
			<?php for ($i = 0; $i < 2; $i++) {?>
			<div class="col-md-6 chart">
				<div class="chart-content">
					<h3 class="chart-cap">Total fans number</h3>
					<canvas id="canvas-<?=$i?>"></canvas>
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
			<?php }?>
		</div>
	</div>
</div>