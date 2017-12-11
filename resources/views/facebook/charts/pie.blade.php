<script type="text/javascript">
$(window).scroll(function() {
    if ($('#' + {!! json_encode($id) !!}).isOnScreen()) {
        if ($('#' + {!! json_encode($id) !!}).data("generated")) {
            return;
        }
        $('#' + {!! json_encode($id) !!}).data("generated", true);
            var ctx = document.getElementById({!! json_encode($id) !!}).getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'pie',
              options: {
                animation:{
                  duration : Math.round(50000 / 17),
                },
                legend: {
                    display: true,
                    position: 'bottom',
                }
            },
              data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                  backgroundColor: {!! json_encode($colors) !!},
                  data: {!! json_encode($data) !!}
                }]
              }
        });
        othercharts.push(myChart);
    }
});
</script>
