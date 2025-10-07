@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">WIG</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var options = {
            series: [{
                name: 'XYZ MOTORS',
                data : [{
                    x: new Date('2018-02-12').getTime(),
                    y: 76
                }, {
                    x: new Date('2018-02-13').getTime(),
                    y: 78
                }, {
                    x: new Date('2018-02-14').getTime(),
                    y: 82
                }, {
                    x: new Date('2018-02-15').getTime(),
                    y: 80
                }, {
                    x: new Date('2018-02-16').getTime(),
                    y: 85
                }]
            }],
            chart: {
                type: 'area',
                stacked: false,
                height: 500,
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            title: {
                text: 'WIG',
                align: 'center'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0,
                    stops: [0, 90, 100]
                },
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return (val / 1000000).toFixed(0);
                    },
                },
                title: {
                    text: 'Price'
                },
            },
            xaxis: {
                type: 'datetime',
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function(val) {
                        return (val / 1000000).toFixed(0)
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
