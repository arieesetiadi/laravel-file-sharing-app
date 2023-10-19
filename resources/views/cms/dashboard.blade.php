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
                <div class="col-12 col-sm-12 col-lg-6">
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
                <div class="col-12 col-sm-12 col-lg-6">
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
                <div class="col-12 col-sm-12 col-lg-6">
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
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card widget widget-stats cursor-pointer" data-bs-toggle="modal"
                        data-bs-target="#files-modal">
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
                    <div class="modal fade" id="files-modal" tabindex="-1" aria-labelledby="files-modal-label"
                        aria-hidden="true">
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
                        <div class="card-body table-responsive">
                            <table class="w-100 datatable table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Files</th>
                                        <th>Shared</th>
                                    </tr>
                                </thead>
                                <tbody id="received-shares">
                                    @forelse ($shares as $i => $share)
                                        <tr>
                                            <td class="text-nowrap">{{ $share->title }}</td>
                                            <td class="text-nowrap">{{ $share->description }}</td>

                                            <td class="text-nowrap">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="javascript:void(0)" role="button"
                                                        id="dropdown-links-{{ $share->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Files
                                                    </a>

                                                    <ul class="dropdown-menu" aria-labelledby="dropdown-links-{{ $share->id }}">
                                                        @foreach ($share->files as $file)
                                                            <li>
                                                                <a target="_blank" class="dropdown-item" href="{{ asset($file->url) }}">
                                                                    {{ $file->name }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>

                                            <td class="text-nowrap">{{ $share->created_at }} by {{ $share->sendingUser->name }}</td>
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

{{-- Realtime Client --}}
@if (auth()->user()->is_general)
    @pushOnce('after-scripts')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = false;

            const pusher = new Pusher(`{{ config('broadcasting.connections.pusher.key') }}`, {
                cluster: `{{ config('broadcasting.connections.pusher.options.cluster') }}`
            });

            const channel = pusher.subscribe('files-sharing-channel');

            channel.bind('files-shared-event', function({share}) {
                if (share.receiving_users.some(user => user.id == `{{ auth()->id() }}`)) {
                    let key = Date.now();
                    let newRowElement = `
                        <tr role="row">
                            <td class="text-nowrap">${share.title}</td>
                            <td class="text-nowrap">${share.description}</td>

                            <td class="text-nowrap">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="javascript:void(0)" role="button"
                                        id="dropdown-links-${share.id}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Files
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdown-links-${share.id}">
                                        ${generateFileLinks(share.files)}
                                    </ul>
                                </div>
                            </td>

                            <td class="text-nowrap">${share.created_at} by ${share.sending_user.name}</td>
                        </tr>
                    `;

                    $('tbody#received-shares').prepend(newRowElement);
                }
            });
        </script>

        <script>
            function generateFileLinks(files) {
                let fileLinks = '';

                files.forEach(file => {
                    fileLinks += `
                        <li>
                            <a target="_blank" class="dropdown-item" href="{{ asset('storage/uploads/files/shares') }}/${file.name}">
                                ${file.name}
                            </a>
                        </li>
                    `;
                });

                return fileLinks;
            }
        </script>
    @endPushOnce
@endif
