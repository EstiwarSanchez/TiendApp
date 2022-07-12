@props(['datachart' => [], 'title' => '', 'labels' => [], 'type' => 'line', 'months' =>
['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV', 'DIC']])
@php
$ref = 'chart_line_'.randomString($length = 8);
@endphp
@if ($title)
<h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
    {{$title}}
</h4>
@endif
<div class="h-96 w-full mx-auto text-center">
    <canvas id="{{$ref}}"></canvas>
</div>
<div class="flex justify-center mx-auto mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
    <!-- Chart legend -->
    @foreach ($labels as $label)
    <div class="flex items-center">
        <span class="inline-block w-3 h-3 mr-1 rounded-full"
            style="background-color: {{$label['backgroundColor'] ?? '#03A8D5'}}"></span>
        <span>{{$label['label']}}</span>
    </div>
    @endforeach
</div>
<script>
    var ctx = document.getElementById('{{$ref}}');

    charts['{!! $ref !!}'] = new Chart(ctx, {
        type: '{!! $type !!}',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [
            {
                label:  "GB",
                borderWidth: 1,
                pointBackgroundColor: "white",
                pointHoverBackgroundColor: "white",
                backgroundColor : '#72BC23',
                borderColor : '#72BC23',
                pointBorderWidth: 3.4,
                pointRadius: 4,
                pointStyle: "circle",
                pointHoverRadius: 6,
                data: {{'['.implode(',', $datachart['gb']).']'}}
            },
            {
                label:  "{!!__('Downloads')!!}",
                borderWidth: 1,
                pointBackgroundColor: "white",
                pointHoverBackgroundColor: "white",
                backgroundColor : '#03A8D5',
                borderColor : '#03A8D5',
                pointBorderWidth: 3.4,
                pointRadius: 4,
                pointStyle: "circle",
                pointHoverRadius: 6,
                data: {{'['.implode(',', $datachart['downloads']).']'}}
            },
            {
                label:  "{!!__('Uploads')!!}",
                borderWidth: 1,
                pointBackgroundColor: "white",
                pointHoverBackgroundColor: "white",
                backgroundColor: "#E4891F",
                borderColor : '#E4891F',
                pointBorderWidth: 3.4,
                pointRadius: 4,
                pointStyle: "circle",
                pointHoverRadius: 6,
                data: {{'['.implode(',', $datachart['uploads']).']'}}
            },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [
                {
                    ticks: {
                        padding: 10
                    },
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: false
                    }
                }
                ],
                yAxes: [
                {
                    ticks: {
                        fontSize: 11,
                        padding: 10,
                        callback: function(value, index, values) {
                            return value ;
                        },
                        maxTicksLimit: 7
                    },
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: false
                    }
                }
                ]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, chart) {
                        return formatCurrency(
                            "es-CO",
                            "COP",
                            2,
                            tooltipItem.yLabel
                            );
                    }
                }
            },
        }
    });
</script>
