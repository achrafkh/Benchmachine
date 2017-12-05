<script type="text/javascript">
        new Chart(document.getElementById({!! json_encode($id) !!}), {
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
                responsive: false,
                responsiveAnimationDuration: 0,
                animation: { duration: 0 },
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
</script>
