@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Total Departemen</p>
                                <h4 class="card-title mb-0">{{ $totalDepartemen }}</h4>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="bx bx-buildings bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Total WIG</p>
                                <h4 class="card-title mb-0">{{ $totalWig }}</h4>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded p-2">
                                    <i class="bx bx-target-lock bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Total Lead Measure</p>
                                <h4 class="card-title mb-0">{{ $totalLeadMeasure }}</h4>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-info rounded p-2">
                                    <i class="bx bx-list-ul bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Total Task</p>
                                <h4 class="card-title mb-0">{{ $totalTask }}</h4>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded p-2">
                                    <i class="bx bx-task bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Row -->
        <div class="row">
            <div class="col-md-8 col-lg-8 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title m-0">WIG per Departemen</h5>
                    </div>
                    <div class="card-body">
                        <div id="wigChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // WIG per Department Chart
            const wigOptions = {
                series: @json(array_values($wigPerDepartment)),
                chart: {
                    type: 'donut',
                    height: 400
                },
                labels: @json(array_keys($wigPerDepartment)),
                colors: ['#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997', '#e83e8c',
                    '#6610f2', '#007bff', '#6c757d', '#87ceeb', '#ff69b4'
                ]
            }
            const wigChart = new ApexCharts(document.querySelector("#wigChart"), wigOptions);
            wigChart.render();
    });
    </script>
@endpush
