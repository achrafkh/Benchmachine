<script>
    var lineChartData = {
        labels: {!! json_encode($labels) !!},
        datasets: {!! json_encode($data) !!}
    };
        var ctx = document.getElementById({!! json_encode($id) !!}).getContext("2d");
        window.myLine = Chart.Line(ctx, {
            data: lineChartData,
            options: {
                responsiveAnimationDuration: 0,
                animation: { duration: 0 },
                maintainAspectRatio: {!! json_encode($aspect) !!},
                legend: {
                        display: true,
                        position: 'bottom',
                  },
                responsive: false,
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
                        display: true,
                        position: "right",
                        id: "y-axis-2",

                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }],
                }
            }
        });
    </script>
