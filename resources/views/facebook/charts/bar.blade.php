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
                showXLabels: 10,
                responsive: true,
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
                        ticks: {
                            autoSkip: false,
                            maxTicksLimit: 20,
                            showXLabels: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            autoSkip: false
                        }
                    }]
                },
            }
        });
        AOS.refresh();
        othercharts.push(mychart);
    }
});


</script>
