{{-- Master Template --}}
@extends('cms.layouts.master')

{{-- Sidebar Configuration --}}
@php
    $sidebar['users'] = 'active-page';
@endphp

{{-- Content --}}
@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <div class="page-description px-0">
                    <h1>{{ $edit ? 'Edit' : 'Add' }} {{ $titles['singular'] }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="user-{{ !$edit ? 'create' : 'edit' }}" class="row"
                            action="{{ $edit ? route('cms.users.update', $user->id) : route('cms.users.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method($edit ? 'PUT' : 'POST')

                            {{-- Input Username --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-username" class="form-label d-block" for="username">
                                    Username <span class="text-danger">*</span>
                                </label>

                                <input id="username" class="form-control mb-2" name="username" type="text"
                                    value="{{ old('username', $user->username ?? null) }}" aria-describedby="label-username"
                                    placeholder="e.g. robert">

                                {{-- Error --}}
                                @error('username')
                                    <span class="d-block text-danger" for="username">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Name --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-name" class="form-label d-block" for="name">
                                    Name <span class="text-danger">*</span>
                                </label>

                                <input id="name" class="form-control mb-2" name="name" type="text"
                                    value="{{ old('name', $user->name ?? null) }}" aria-describedby="label-name"
                                    placeholder="e.g. Robert Emerson">

                                {{-- Error --}}
                                @error('name')
                                    <span class="d-block text-danger" for="name">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Email --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-email" class="form-label d-block" for="email">
                                    Email <span class="text-danger">*</span>
                                </label>

                                <input id="email" class="form-control mb-2" name="email" type="email"
                                    value="{{ old('email', $user->email ?? null) }}" aria-describedby="label-email"
                                    placeholder="e.g. robert@example.com">

                                {{-- Error --}}
                                @error('email')
                                    <span class="d-block text-danger" for="email">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Phone --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-phone" class="form-label d-block" for="phone">
                                    Phone
                                </label>

                                <input id="phone" class="form-control mb-2 input-number" name="phone" type="text"
                                    value="{{ old('phone', $user->phone ?? null) }}" aria-describedby="label-phone"
                                    placeholder="e.g. 0821xxxxxxxx">

                                {{-- Error --}}
                                @error('phone')
                                    <span class="d-block text-danger" for="phone">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input User Role --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-user-role-id" class="form-label d-block" for="user-role-id">
                                    User Role <span class="text-danger">*</span>
                                </label>

                                <select id="user-role-id" class="form-select mb-2" name="user_role_id"
                                    aria-label="User role select">
                                    <option selected disabled>Choose User Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ check_selected($role->id, old('user_role_id', $user->role->id ?? null)) }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('user_role_id')
                                    <span class="d-block text-danger" for="user_role_id">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Info Status --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label id="label-status" class="form-label d-block" for="status">
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select id="status" class="form-select mb-2" name="status" aria-label="User status select"
                                    aria-disabled="true">
                                    <option selected disabled>Choose Status</option>
                                    @foreach (\App\Constants\GeneralStatus::values() as $status)
                                        <option value="{{ $status }}"
                                            {{ check_selected($status, old('status', $user->status ?? null)) }}>
                                            {{ \App\Constants\GeneralStatus::label($status) }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('status')
                                    <span class="d-block text-danger" for="status">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Password --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <div class="d-flex">
                                    <label id="label-password" class="form-label d-block" for="password">
                                        Password
                                        @if (!$edit)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="d-inline-block form-check form-switch px-5">
                                        <input id="toggle-password" class="form-check-input" name="toggle-password"
                                            type="checkbox" tabindex="-1" onchange="togglePassword(event, 'password')">
                                    </div>
                                </div>

                                <input id="password" class="form-control mb-2" name="password" type="password"
                                    aria-describedby="label-password"
                                    placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">

                                {{-- Error --}}
                                @error('password')
                                    <span class="d-block text-danger" for="password">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex mt-4 gap-2">
                                {{-- Back Button --}}
                                <a class="btn btn-light" type="submit" href="{{ route('cms.users.index') }}">
                                    Back
                                </a>

                                {{-- Submit Button --}}
                                <button class="btn btn-primary" type="submit">
                                    {{ $edit ? 'Update' : 'Submit' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@pushOnce('after-scripts')
    {{-- User Form Validation --}}
    @if (!$edit)
        {!! JsValidator::formRequest('App\Http\Requests\CMS\User\StoreRequest', '#user-create') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\CMS\User\UpdateRequest', '#user-edit') !!}
    @endif
@endPushOnce
