@props(['data' => [], 'colors' => [], 'title' => '', 'labels'=>[]])
@php
$ref = 'chart_pie_'.randomString($length = 8);
if (count($colors)==0) {
    $colors = ramdomColors(count($data));
}
@endphp
@if ($title)
<h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
    {{$title}}
</h4>
@endif
<canvas id="{{$ref}}"></canvas>
<div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
    <!-- Chart legend -->
    @foreach ($labels as $i => $label)
    <div class="flex items-center">
        <span class="inline-block w-3 h-3 mr-1 rounded-full" style="background-color: {{$colors[$i] ?? '#03A8D5'}}"></span>
        <span>{{$label}}</span>
    </div>
    @endforeach
</div>
@push('scripts')
<script>
    var pieConfig = {
        type: 'doughnut',
        data: {
            datasets: [
                {
                    data: [{{implode(',',$data)}}],

                    backgroundColor: [{!!"'".implode("','",$colors)."'"!!}],
                    label: '{{$title}}',
                },
            ],
            labels: [{!!"'".implode("','",$labels)."'"!!}],
        },
        options: {
            responsive: true,
            cutoutPercentage: 100,
            legend: {
                display: false,
            },
        },
    }
    charts['{{$ref}}'] = new Chart(document.getElementById('{{$ref}}').getContext('2d'), pieConfig);
</script>
@endpush
