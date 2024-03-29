<div class="sidebar">
	<div class="sidebar-header">
		<h2 class="sidebar-title" id="countBench">
		</h2>
		<button class="sidebar-close" type="button">
			<i class="b-right-arrow"></i>
		</button>
	</div>
	<div class="sidebar-search">
		<div class="search-wrap">
			<input class="form-control" onkeyup="searchBenchmarks()" type="" id="searchBench" name="search" placeholder="Search..." value="">
			<i class="b-search"></i>
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
		$('#countBench').text('My Benchmarks ('+data.length+')');
		if(data.length == 0 ){
			parent.html('<div class="media sidebar-item"><ul class="media-body media-middle"><li class="si-name text-center">You have no benchmarks yet</li></ul></div>');
			return false;
		}
		parent.empty();
		$.each(data,function(i,v){
			parent.append(getDom(v,(i+1)));
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
			return 'warning';
		}
		return 'success';
	}
}
function getDom(benchmark,index){
	var title = benchmark.title;
	if(title == 'Benchmark'){
		title += ' #'+index;
	}
	var string = '<a data-title="'+title+'" class="media sidebar-item" href="/benchmarks/'+benchmark.id+'"><ul class="media-body media-middle"><li class="si-name">'+title+'</li><li class="si-date">'+benchmark.since +' - '+benchmark.until+'</li></ul><div class="media-right media-middle"><span class="label label-'+getStatus(benchmark.status,true)+'">'+getStatus(benchmark.status)+'</span></div></a>';
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
