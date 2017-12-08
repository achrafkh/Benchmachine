<div class="section-header">
	<h2 class="section-title">
	Best Posts
	</h2>
	<span class="section-cap">
		Benchmark overview (Sorted by {{ ucfirst(str_replace('_',' ',$sort)) }})
	</span>
</div>
<div class="row posts-wrap animatedParent" data-sequence="500">
	@foreach($posts->sortByDesc($sort)->take(4) as $key => $post)
	@include('facebook.sections.partials.single_post')
	@endforeach
</div>
