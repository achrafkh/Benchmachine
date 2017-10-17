<div class="section summary-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
			Summary
			</h2>
			<span class="section-cap">
				Benchmark overview
			</span>
		</div>
		<div class="summary-wrap">
			<ul class="summary-block">
				<li class="summary-data">
					<span class="perc">%</span>
					<span class="digit">{{ number_format($averages->page_engagement, 3, '.', ',') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="up">
						+0.1%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Page average engagement rate
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="perc">%</span>
					<span class="digit">{{ number_format($averages->average_page_engagement, 3, '.', ',') }}</span>
				</li>
				<li class="summary-progress">
					<<!-- span>
						0%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Posts average engagement rate
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->fans, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="up">
						+17.5%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average total fans number
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->absolute_fans, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="down">
						-4.7%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average new fans number
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->posts, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="up">
						+1.6%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average posts number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">
					@if(isset($averages->posts) && $averages->posts > 0)
					{{ number_format(
						$averages->interactions/$averages->posts
					 , 0, '.', ' ') }}
					@else
					0
					@endif
					 </span>
				</li>
				<li class="summary-progress">
				<!-- 	<span class="down">
						-2.1%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Nombre des interactions moyen par post
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->interactions, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="up">
						+9.4%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average interaction number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->likes, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
				<!-- 	<span class="up">
						+5.1%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average likes number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->comments, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
				<!-- 	<span class="down">
						-5.1%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average comments number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit">{{ number_format($averages->shares, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<!-- <span class="up">
						+4.9%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span> -->
				</li>
				<li class="summary-cap">
					Average shares number by page
				</li>
			</ul>
		</div>
	</div>
</div>
