{{-- Master Template --}}
@extends('cms.layouts.master')

{{-- Sidebar Configuration --}}
@php
    $sidebar['dashboard'] = 'active-page';
@endphp

{{-- Content --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-description px-0">
                    <h1>{{ $title ?? 'Title' }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="card widget widget-stats">
                    <div class="card-body">
                        <div class="widget-stats-container d-flex">
                            <div class="widget-stats-icon widget-stats-icon-primary">
                                <i class="material-icons-outlined">person</i>
                            </div>
                            <div class="widget-stats-content flex-fill">
                                <span class="widget-stats-title">Total General Users</span>
                                <span class="widget-stats-amount">{{ $count['general'] }}</span>
                                <span class="widget-stats-info">141 Orders Total</span>
                            </div>
                            <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                <i class="material-icons">keyboard_arrow_up</i> 4%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="card widget widget-stats">
                    <div class="card-body">
                        <div class="widget-stats-container d-flex">
                            <div class="widget-stats-icon widget-stats-icon-primary">
                                <i class="material-icons-outlined">person</i>
                            </div>
                            <div class="widget-stats-content flex-fill">
                                <span class="widget-stats-title">Total Administrators</span>
                                <span class="widget-stats-amount">{{ $count['admin'] }}</span>
                                <span class="widget-stats-info">141 Orders Total</span>
                            </div>
                            <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                <i class="material-icons">keyboard_arrow_up</i> 4%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card widget widget-stats-large">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="widget-stats-large-chart-container">
                                <div class="card-header">
                                    <h5 class="card-title">Earnings<span class="badge badge-light badge-style-light">Last Year</span></h5>
                                </div>
                                <div class="card-body">
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="widget-stats-large-info-container">
                                <div class="card-header">
                                    <h5 class="card-title">Report<span class="badge badge-info badge-style-light">Updated 5 min ago</span></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-description">Duis fringilla eget velit sit amet lobortis. Donec rutrum, arcu auctor varius cursus. mi nulla dapibus justo, at volutpat libero</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Neptune - v1.0<span class="float-end text-success">14%<i class="material-icons align-middle">keyboard_arrow_up</i></span></li>
                                        <li class="list-group-item">Space - v1.2<span class="float-end text-danger">7%<i class="material-icons align-middle">keyboard_arrow_down</i></span></li>
                                        <li class="list-group-item">Lime - v1.0.3<span class="float-end text-success">21%<i class="material-icons align-middle">keyboard_arrow_up</i></span></li>
                                        <li class="list-group-item">Circl - v2.3<span class="float-end text-success">17%<i class="material-icons align-middle">keyboard_arrow_up</i></span></li>
                                        <li class="list-group-item">Connect - v1.7<span class="float-end text-danger">3%<i class="material-icons align-middle">keyboard_arrow_down</i></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('after-scripts')
    {{-- Apex Chart --}}
    <script src="{{ asset('assets/cms/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        const chart = new ApexCharts(
            document.querySelector("#chart"), {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        borderRadius: 10
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Net Profit',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                }, {
                    name: 'Revenue',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                }],
                xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    labels: {
                        style: {
                            colors: 'rgba(94, 96, 110, .5)'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: '$ (thousands)'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " thousands"
                        }
                    }
                },
                grid: {
                    borderColor: '#e2e6e9',
                    strokeDashArray: 4
                }
            }
        );

        chart.render();
    </script>
@endPushOnce
