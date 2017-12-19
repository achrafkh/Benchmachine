<div class="section-header">
	<h2 class="section-title">
	Best Posts
	</h2>
	<span class="section-cap">
		Benchmark overview (Sorted by {{ ucfirst(str_replace('_',' ',$sort)) }})
	</span>
</div>
<div class="row nm-7 animatedParent" data-sequence="500">
	@foreach($posts->flatten()->sortByDesc($sort)->take(4) as $key => $post)
		@include('facebook.sections.partials.single_post_print')
	@endforeach
</div>
