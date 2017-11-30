<script type="text/javascript">
$(window).scroll(function() {
    if ($('#' + {!! json_encode($id) !!}).isOnScreen()) {
        if ($('#' + {!! json_encode($id) !!}).data("generated")) {
            return;
        }
        $('#' + {!!json_encode($id) !!}).data("generated", true);


		var ctx = document.getElementById({!!json_encode($id) !!}).getContext("2d");

		var data = {
		    labels: {!! json_encode($labels) !!},
		    datasets: {!!  json_encode($data) !!}
		};
		console.log(data);
		var myBarChart = new Chart(ctx, {
		    type: 'bar',
		    data: data,
		    options: {
		        barValueSpacing: 20,
		        scales: {
		            yAxes: [{
		                ticks: {
		                    min: 0,
		                }
		            }]
		        },
			        animation:{
	                  duration : Math.round(50000 / 17),
	                },
	                legend: {
	                    display: true,
	                    position: 'bottom',
	                },
            	},
		});
    }
});
</script>
