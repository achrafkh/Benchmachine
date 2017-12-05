<script type="text/javascript">
            var ctx = document.getElementById({!! json_encode($id) !!}).getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'pie',
              options: {
                responsive: false,
                responsiveAnimationDuration: 0,
                animation: { duration: 0 },
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
</script>
