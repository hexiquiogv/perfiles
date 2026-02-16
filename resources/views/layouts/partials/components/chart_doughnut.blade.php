<canvas id="doughnutchart_{{$id}}" style="max-width: 500px;" class="p-2"></canvas>

@push('scripts2')
  <script>
  //radar
  var ctxR = document.getElementById("doughnutchart_{{$id}}").getContext('2d');
  var myDoughnutChart = new Chart(ctxR, {
    type: 'doughnut',
    data: {
      labels: [{!!$data["labels"]!!}],
      datasets: [
          {
              label: "{!! $data['title'] !!}",
              data: [{!!$data["valores"]!!}],
              backgroundColor: [{!!$data["colores"]!!}],
              borderColor: [{!!$data["colores"]!!}],
              borderWidth: 2
          },
      ]
    },
    options: {
      responsive: true
    }
  });

</script>
@endpush

