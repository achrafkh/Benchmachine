<div class="sidebar">
	<div class="sidebar-header">
		<h2 class="sidebar-title">
			My Benchmarks (5)
		</h2>
		<button class="sidebar-close" type="button">
			<svg class="svg" role="img" title="right-arrow" width="20" height="20">
        		<use xlink:href="/assets/images/svg-icons.svg#icon-right-arrow"/>
        	</svg>
		</button>
	</div>
	<div class="sidebar-search">
		<div class="search-wrap">
			<input class="form-control" onkeyup="searchBenchmarks()" type="" id="searchBench" name="search" placeholder="Search..." value="">
			<svg class="svg" role="img" title="search" width="18" height="18">
        		<use xlink:href="/assets/images/svg-icons.svg#icon-search"/>
        	</svg>
		</div>
	</div>
	<div class="sidebar-body" id="listParent">

	</div>
</div>
<div class="sidebar-backlayer"></div>


<script type="text/javascript">
function updateBenchmarks(){
	var parent = $('#listParent');
	$.get( "/api/benchmarks", function( data ) {}).then(function(data){
		if(data.length == 0 ){
			parent.append('<div class="media sidebar-item"><ul class="media-body media-middle"><li class="si-name text-center">You have no benchmarks yet</li></ul></div>');
			return false;
		}
		parent.empty();
		$.each(data,function(i,v){
			parent.append(getDom(v));
		});
	});
}
function getStatus(status,className = false){
	if(className == false){
		if(status == 1){
			return 'Pending';
		}
		return 'Ready';
	} else {
		if(status == 1){
			return 'orange';
		}
		return 'green';
	}
}
function getDom(benchmark){
	var string = '<a data-title="'+benchmark.title+'" class="media sidebar-item" href="/benchmarks/'+benchmark.id+'"><ul class="media-body media-middle"><li class="si-name">'+benchmark.title+'</li><li class="si-date">'+benchmark.since +' - '+benchmark.until+'</li></ul><div class="media-right media-middle"><span class="si-badge bg-'+getStatus(benchmark.status,true)+'">'+getStatus(benchmark.status)+'</span></div></a>';
	return string;
}


function searchBenchmarks() {
	var filter;
	filter = $("#searchBench").val().toUpperCase();
	$(".sidebar-item").each(function (index) {
		if ($(this).data('title').toUpperCase().indexOf(filter) > -1) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
}

</script>
