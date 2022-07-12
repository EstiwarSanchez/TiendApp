@props(['data' => [], 'title' => '', 'labels'=>[]])
@php
$ref = 'chart_line_'.randomString($length = 8);
@endphp
@if ($title)
<h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
    {{$title}}
</h4>
@endif
<canvas id="{{$ref}}"></canvas>
<div class="flex justify-center mx-auto mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
    <!-- Chart legend -->
    @foreach ($data as $label)
    <div class="flex items-center">
        <span class="inline-block w-3 h-3 mr-1 rounded-full"
            style="background-color: {{$label['backgroundColor'] ?? '#03A8D5'}}"></span>
        <span>{{$label['label']}}</span>
    </div>
    @endforeach
</div>
@push('scripts')
<script>
    var lineConfig = {
      type: 'line',
      data: {
        labels: [{!!"'".implode("','",$labels)."'"!!}],
        datasets: {!! json_encode($data) !!},
      },
      options: {
        responsive: true,
        legend: {
          display: false,
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true,
        },
        scales: {
          x: {
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Mes',
            },
          },
          y: {
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Value',
            },
          },
        },
      },
    }
    charts['{{$ref}}'] = new Chart(document.getElementById('{{$ref}}').getContext('2d'), lineConfig);
</script>
@endpush
