<div class="section posts-section" data-aos="slide-up" data-aos-once="true" data-aos-duration="2300" data-aos-delay="900" data-aos-offset="1200">
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
