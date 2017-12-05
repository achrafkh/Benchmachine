<script type="text/javascript">
		var ctx = document.getElementById({!!json_encode($id) !!}).getContext("2d");

		var data = {
		    labels: {!! json_encode($labels) !!},
		    datasets: {!!  json_encode($data) !!}
		};

		var myBarChart = new Chart(ctx, {
		    type: 'bar',
		    data: data,
		    options: {
		    	responsive: false,
                responsiveAnimationDuration: 0,
                animation: { duration: 0 },
		        barValueSpacing: 20,
		        scales: {
		            yAxes: [{
		                ticks: {
		                    min: 0,
		                }
		            }]
		        },
			        animation:false,
	                legend: {
	                    display: true,
	                    position: 'bottom',
	                },
            	},
		});
</script>
