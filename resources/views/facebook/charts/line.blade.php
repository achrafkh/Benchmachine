 <script>
function randomScalingFactor(){
 	return Math.round(Number(Math.random(0,500) * 100));
 }
 console.log({!! json_encode($id) !!})
 $(window).scroll(function() {
    if ($('#'+{!! json_encode($id) !!}).isOnScreen()) {
        if ($('#'+{!! json_encode($id) !!}).data("generated")) {
            return;
        }
        $('#'+{!! json_encode($id) !!}).data("generated", true);
    var lineChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "Ooredoo",
            borderColor: "#FF6384",
            backgroundColor: "#FF6384",
            fill: false,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ],
            yAxisID: "y-axis-1",
        }, {
            label: "Orange",
            borderColor: "#36A2EB",
            backgroundColor: "#36A2EB",
            fill: false,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ],
            yAxisID: "y-axis-2"
        }, {
            label: "Tunisie Telecome",
            borderColor: "#4BC0C0",
            backgroundColor: "#4BC0C0",
            fill: false,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ],
            yAxisID: "y-axis-2"
        }]
    };


        var ctx = document.getElementById({!! json_encode($id) !!}).getContext("2d");

        window.myLine = Chart.Line(ctx, {
            data: lineChartData,
            options: {
            	maintainAspectRatio: true,
            	legend: {
	                    display: true,
	                    position: 'bottom',
	              },
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title:{
                    display: false,
                    text:'Chart.js Line Chart - Multi Axis'
                },
                scales: {
                    yAxes: [{
                        type: "linear",
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                    }, {
                        type: "linear",
                        display: true,
                        position: "right",
                        id: "y-axis-2",

                        gridLines: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    }],
                }
            }
        });
 }
});
    </script>
