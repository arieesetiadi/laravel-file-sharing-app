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

        {{-- Admin Only --}}
        @if (auth()->user()->is_admin)
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">share</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Shares</span>
                                    <span class="widget-stats-amount">{{ $count['shares'] }}</span>
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
                                    <i class="material-icons-outlined">description</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Files Shared</span>
                                    <span class="widget-stats-amount">{{ $count['files'] }}</span>
                                </div>
                                <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                    <i class="material-icons">keyboard_arrow_up</i> 4%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- General Only --}}
        @if (auth()->user()->is_general)
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">share</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Received Shares</span>
                                    <span class="widget-stats-amount">{{ $user->receivedShares()->count() }}</span>
                                </div>
                                <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                    <i class="material-icons">keyboard_arrow_up</i> 4%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="card widget widget-stats cursor-pointer" data-bs-toggle="modal" data-bs-target="#files-modal">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">description</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Received Files</span>
                                    <span class="widget-stats-amount">{{ $user->received_files->count() }}</span>
                                </div>
                                <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                    <i class="material-icons">keyboard_arrow_up</i> 4%
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="files-modal" tabindex="-1"
                        aria-labelledby="files-modal-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="files-modal-label">All Received Files
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="w-100 table">
                                        <tr>
                                            <th>#</th>
                                            <th>File</th>
                                        </tr>
                                        @foreach ($user->received_files as $i => $file)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <a target="_blank" href="{{ asset($file->url) }}">
                                                        {{ $file->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Received Shares</h6>
                        </div>
                        <div class="card-body">
                            <table class="w-100 datatable table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sender</th>
                                        <th>Title</th>
                                        <th>Details</th>
                                        <th>Sent At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($shares as $i => $share)
                                        <tr>
                                            <td class="text-nowrap">{{ $i + 1 }}</td>
                                            <td class="text-nowrap">{{ $share->sendingUser->name }}</td>
                                            <td class="text-nowrap">{{ $share->title }}</td>

                                            <td class="text-nowrap">
                                                <!-- Button trigger modal -->
                                                <a type="button" class="text-decoration-none" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail-modal-{{ $i }}">
                                                    Detail
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="detail-modal-{{ $i }}"
                                                    tabindex="-1" aria-labelledby="detail-modal-{{ $i }}-label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="detail-modal-{{ $i }}-label">Detail
                                                                    Share
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="w-100 table">
                                                                    <tr>
                                                                        <td>Title</td>
                                                                        <td>:</td>
                                                                        <td>{{ $share->title }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Description</td>
                                                                        <td>:</td>
                                                                        <td>{{ $share->description ?: '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sent At</td>
                                                                        <td>:</td>
                                                                        <td>{{ human_datetime($share->created_at) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Shared Files</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <ol class="px-3">
                                                                                @foreach ($share->files as $file)
                                                                                    <li>
                                                                                        <a target="_blank"
                                                                                            href="{{ asset($file->url) }}">{{ $file->name }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ol>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-nowrap">{{ human_datetime($share->created_at) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td id="test" class="text-center" colspan="6">
                                                Data is not available right now.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
