<canvas id="lineChart_{{$id}}" style="max-width: 500px;" class="p-2"></canvas>

@push('scripts2')
  <script>
    //line
    var ctxL = document.getElementById("lineChart_{{$id}}").getContext('2d');
    var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
        labels: [{!!$data["labels"]!!}],
        datasets: [{
            label: "{!! $data["title"] !!}",
            data: [{!!$data["valores"]!!}],
            backgroundColor: [{!!$data["colores"]!!}],
            borderColor: [{!!$data["colores"]!!}],
            borderWidth: 2
          }
        ]
      },
      options: {
        responsive: true
      }
    });

  </script>
@endpush

