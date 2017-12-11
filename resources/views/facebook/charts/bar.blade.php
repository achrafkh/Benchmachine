<script type="text/javascript">
$(window).scroll(function() {
    if ($('#' + {!! json_encode($id) !!}).isOnScreen()) {
        if ($('#' + {!! json_encode($id) !!}).data("generated")) {
            return;
        }
        $('#' + {!!json_encode($id) !!}).data("generated", true);
        var mychart = new Chart(document.getElementById({!! json_encode($id) !!}), {
            type: 'bar',

            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: {!! json_encode($label) !!},
                    backgroundColor: {!!json_encode($colors) !!},
                    data: {!! json_encode($data) !!}
                }]
            },
            options: {
                animation:{
                  duration : Math.round(50000 / 17),
                },
                legend: {
                    display: false,
                    position: 'bottom',
                    labels: {
                        fontColor: "#000080",
                    }
                },
                scales: {
                    xAxes: [{
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            min: 0,
                            autoSkip: false
                        }
                    }]
                },
            }
        });

        othercharts.push(mychart);
    }
});
</script>
