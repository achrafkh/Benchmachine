<div class="section posts-section" data-aos="slide-up" data-aos-once="true" data-aos-duration="800" data-aos-delay="600" data-aos-offset="800">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
			{{ ucfirst($sort_title) }}
			</h2>
			<span class="section-cap" style="text-transform: uppercase;">
				Best posts
			</span>
		</div>
		<div class="row nm-7">
		@foreach($posts->flatten()->sortByDesc($sort)->take(4) as $key => $post)
			@include('facebook.sections.partials.single_post')
		@endforeach
		</div>
	</div>
</div>
