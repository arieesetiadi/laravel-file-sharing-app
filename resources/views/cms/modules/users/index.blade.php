{{-- Master Template --}}
@extends('cms.layouts.master')

{{-- Sidebar Configuration --}}
@php
    $sidebar['users'] = 'active-page';
@endphp

{{-- Content --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-description px-0 d-flex align-items-center">
                    <div class="page-description-content flex-grow-1">
                        <h1>{{ $titles['plural'] }}</h1>
                    </div>
                    <div class="page-description-actions">
                        <a class="btn btn-primary" href="{{ route('cms.users.create') }}">
                            Add {{ $titles['singular'] }}
                        </a>
                        <a class="btn btn-success" href="{{ route('cms.users.excel') }}" target="_blank">
                            Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="w-100 table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">Actions</th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $i => $user)
                                    <tr>
                                        <td class="d-flex justify-content-center">
                                            <div class="btn-group dropend">
                                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    {{-- Edit Button --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('cms.users.edit', $user->id) }}">Edit</a>
                                                    </li>

                                                    {{-- Toggle Status Button --}}
                                                    <li>
                                                        <form action="{{ route('cms.users.toggle', $user->id) }}" method="POST">
                                                            @csrf
                                                            <a class="dropdown-item" type="button" onclick="swalConfirm(event)">
                                                                {{ $user->status ? 'Inactivate' : 'Activate' }}
                                                            </a>
                                                        </form>
                                                    </li>

                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>

                                                    {{-- Delete Button --}}
                                                    <li>
                                                        <form action="{{ route('cms.users.destroy', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="dropdown-item" type="button" onclick="swalConfirm(event)">
                                                                Delete
                                                            </a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">{{ $i + 1 }}</td>
                                        <td class="text-nowrap">{{ $user->name }}</td>
                                        <td class="text-nowrap">{{ $user->email }}</td>
                                        <td class="text-nowrap">{{ $user->role->name }}</td>
                                        <td class="text-nowrap">{!! \App\Constants\GeneralStatus::htmlLabel($user->status) !!}</td>
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
    </div>
@endsection
