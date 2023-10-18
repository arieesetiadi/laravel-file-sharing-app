{{-- Master Template --}}
@extends('cms.layouts.master')

{{-- Sidebar Configuration --}}
@php
    $sidebar['shares'] = 'active-page';
@endphp

{{-- Styles --}}
@pushOnce('after-styles')
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{ asset('assets/cms/plugins/select2/css/select2.min.css') }}">
@endPushOnce

{{-- Content --}}
@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <div class="page-description px-0">
                    <h1>Share Files</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="share-{{ !$edit ? 'create' : 'edit' }}" class="row"
                            action="{{ $edit ? route('cms.shares.update', $share->id) : route('cms.shares.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method($edit ? 'PUT' : 'POST')

                            {{-- Input Title --}}
                            <div class="col-12 mb-3">
                                <label id="label-title" class="form-label d-block" for="title">
                                    Title <span class="text-danger">*</span>
                                </label>

                                <input id="title" class="form-control mb-2" name="title" type="text"
                                    value="{{ old('title', $user->title ?? null) }}" aria-describedby="label-title"
                                    placeholder="e.g. Meeting Files">

                                {{-- Error --}}
                                @error('title')
                                    <span class="d-block text-danger" for="title">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Description --}}
                            <div class="col-12 mb-3">
                                <label id="label-description" class="form-label d-block" for="description">
                                    Description
                                </label>

                                <textarea rows="4" id="description" class="form-control mb-2" name="description" aria-describedby="label-description"
                                    placeholder="e.g. These are the meeting related files..">{{ old('description', $user->description ?? null) }}</textarea>

                                {{-- Error --}}
                                @error('description')
                                    <span class="d-block text-danger" for="description">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input File --}}
                            <div class="col-12 mb-3">
                                <label id="label-files" class="form-label d-block" for="files">
                                    Upload File(s) <span class="text-danger">*</span>
                                </label>

                                <input id="files" class="form-control mb-2" name="files[]" type="file"
                                    value="{{ old('files', $file->files ?? null) }}" aria-describedby="label-files" multiple>

                                {{-- Error --}}
                                @error('files')
                                    <span class="d-block text-danger" for="files">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Input Target User(s) --}}
                            <div class="col-12 mb-3">
                                <label id="label-user-ids" class="form-label d-block" for="user-ids">
                                    Target User(s) <span class="text-danger">*</span>
                                </label>

                                <select id="user-ids" class="form-select select-2" name="user_ids[]" multiple
                                    aria-label="User select" data-placeholder="Select Target Users">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('user_ids')
                                    <span class="d-block text-danger" for="user_ids">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex mt-4 gap-2">
                                {{-- Back Button --}}
                                <a class="btn btn-light" type="submit" href="{{ route('cms.shares.index') }}">
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
    {{-- Select 2 --}}
    <script src="{{ asset('assets/cms/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select-2').select2();
        })
    </script>

    {{-- User Form Validation --}}
    @if (!$edit)
        {!! JsValidator::formRequest('App\Http\Requests\CMS\Share\StoreRequest', '#share-create') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\CMS\Share\UpdateRequest', '#share-edit') !!}
    @endif
@endPushOnce
