<script>


 $(window).scroll(function() {
    if ($('#'+{!! json_encode($id) !!}).isOnScreen()) {
        if ($('#'+{!! json_encode($id) !!}).data("generated")) {
            return;
        }
        $('#'+{!! json_encode($id) !!}).data("generated", true);
    var lineChartData = {
        labels: {!! json_encode($labels) !!},
        datasets: {!! json_encode($data) !!}
    };
        var the_id = {!! json_encode($id) !!};
        var ctx = document.getElementById({!! json_encode($id) !!}).getContext("2d");
        window.myLine = Chart.Line(ctx, {
            data: lineChartData,
            options: {
            	maintainAspectRatio: {!! json_encode($aspect) !!},
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
                        beginAtZero:true,
                        type: "linear",
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                    }, {
                        type: "linear",
                        display: false,
                        position: "right",
                        id: "y-axis-2",

                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }],
                }
            }
        });
        if(the_id == 'canvas-engagment'){
            charts[0] = window.myLine;
        } else {
            charts[1] = window.myLine;
        }
        AOS.refresh();
 }
});
    </script>
