<div class="section posts-section" data-aos="slide-up" data-aos-once="true" data-aos-duration="1000" data-aos-delay="300" data-aos-offset="350">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
			{{ ucfirst($sort_title) }}
			</h2>
			<span class="section-cap" style="text-transform: uppercase;">
				Best posts
			</span>
		</div>
		<div class="row posts-wrap">
		@foreach($posts->sortByDesc($sort)->take(4) as $key => $post)
			@include('facebook.sections.partials.single_post_print')
		@endforeach
		</div>
	</div>
</div>
