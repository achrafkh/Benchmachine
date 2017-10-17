<div class="section posts-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
			Best Posts
			</h2>
			<span class="section-cap">
				Benchmark overview (Sorted by {{ ucfirst(str_replace('_',' ',$sort)) }})
			</span>
		</div>
		<div class="row posts-wrap">
		@foreach($posts->sortBy($sort)->take(8) as $post)
			@include('facebook.sections.partials.single_post')
		@endforeach
		</div>
	</div>
</div>
