<div class="section summary-section" >
	<div class="container">
	<div class="benchmark-name" >
		<div class="container">
		@if(Session::has('flash'))
		<div class="alert alert-{{ Session::get('flash')['class'] }}">
		  {!! Session::get('flash')['msg'] !!}
		</div>
		@endif
			<input id="original" type="hidden" name="o_title" value="{{ $benchmark->details->title }}">
			<input class="animated bounceInDown" data-id="1" id="title" type="text" name="title" placeholder="Benchmark" value="{{ isset($benchmark->details->title) ? $benchmark->details->title : '' }}">
		</div>
	</div>
		<div class="section-header">
			<h2 class="section-title">
				Summary
			</h2>
			<span class="section-cap">
				Average Kpi’s
			</span>
		</div>
		<div class="summary-wrap active">
			<ul class="summary-block ">
				<li class="summary-data">
					<span class="perc">%</span>
					<span class="digit">{{ number_format($averages->page_engagement, 3, '.', ',') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->page_engagement->class }}">
						 {{ $variations->averages->page_engagement->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
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
					<span class=" {{ $variations->averages->average_page_engagement->class }}">
						 {{ $variations->averages->average_page_engagement->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Posts average engagement rate
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->fans, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->fans->class }}">
						 {{ $variations->averages->fans->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average total fans number
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->absolute_fans, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->absolute_fans->class }}">
						 {{  $variations->averages->absolute_fans->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average new fans number
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->posts, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->posts->class }}">
						 {{ $variations->averages->posts->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average posts number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">
 							{{ number_format($averages->post_interactions_avg, 0, '.', ' ') }}
					 </span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->post_interactions_avg->class }}">
						 {{  $variations->averages->post_interactions_avg->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Nombre des interactions moyen par post
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->interactions, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->interactions->class }}">
						 {{ $variations->averages->interactions->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average interaction number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->likes, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->likes->class }}">
						 {{ $variations->averages->likes->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average likes number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->comments, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->comments->class }}">
						 {{ $variations->averages->comments->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average comments number by page
				</li>
			</ul>
			<ul class="summary-block">
				<li class="summary-data">
					<span class="digit animateMe">{{ number_format($averages->shares, 0, '.', ' ') }}</span>
				</li>
				<li class="summary-progress">
					<span class=" {{ $variations->averages->shares->class }}">
						 {{  $variations->averages->shares->prct }}%
						<i class="icon-down-dir"></i>
						<i class="icon-up-dir"></i>
					</span>
				</li>
				<li class="summary-cap">
					Average shares number by page
				</li>
			</ul>
		</div>
	</div>
</div>
