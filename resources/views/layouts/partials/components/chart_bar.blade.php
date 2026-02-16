<canvas id="chart_{{$id}}" style="max-width: 500px;" class="p-2"></canvas>

@push('scripts2')
  <script>
    var ctx = document.getElementById("chart_{{$id}}").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [{!!$data["labels"]!!}],
          datasets: [
            {
            label: "{!! $data['title'] !!}",
            data: [{!!$data["valores"]!!}],
            backgroundColor: [{!!$data["colores"]!!}],
            borderColor: [{!!$data["colores"]!!}],
            borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
    });
  </script>

@endpush

