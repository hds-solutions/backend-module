@extends('backend::layouts.master')

@section('page-name', __('backend::files.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                @lang('backend::files.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.files.create') }}" class="btn btn-sm btn-primary">@lang('backend::files.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.files.store') }}" enctype="multipart/form-data">
            @csrf
            @include('backend::files.form')
        </form>
    </div>
</div>

@endsection