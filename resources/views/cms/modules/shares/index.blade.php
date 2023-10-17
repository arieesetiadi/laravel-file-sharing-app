{{-- Master Template --}}
@extends('cms.layouts.master')

{{-- Sidebar Configuration --}}
@php
    $sidebar['shares'] = 'active-page';
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
                        <a class="btn btn-primary" href="{{ route('cms.shares.create') }}">
                            {{ $titles['singular'] }} Files
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
                                    <th>Sender</th>
                                    <th>Title</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shares as $i => $share)
                                    <tr>
                                        <td class="d-flex justify-content-center">
                                            <div class="btn-group dropend">
                                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    {{-- Delete Button --}}
                                                    <li>
                                                        <form action="{{ route('cms.shares.destroy', $share->id) }}" method="POST">
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
                                        <td class="text-nowrap">Robert</td>
                                        <td class="text-nowrap">{{ $share->title }}</td>
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
    </div>
@endsection
