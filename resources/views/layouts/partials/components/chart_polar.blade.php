<canvas id="radarchart_{{$id}}" style="max-width: 500px;" class="p-2"></canvas>

@push('scripts2')
  <script>
  //radar
  var ctxR = document.getElementById("radarchart_{{$id}}").getContext('2d');
  var myRadarChart = new Chart(ctxR, {
    type: 'radar',
    data: {
      labels: [{!!$data["labels"]!!}],
      datasets: [
          {
            label: "{!! $data['title'] !!}",
            data: [{!!$data["valores"]!!}],
            backgroundColor: [{!!$color!!}],
            borderColor: [{!!$color!!}],
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

