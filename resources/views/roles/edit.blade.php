@extends('backend::layouts.master')

@section('page-name', __('backend::roles.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-company-plus mr-2"></i>
                @lang('backend::roles.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.roles.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('backend::roles.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.roles.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend::roles.form')
        </form>
    </div>
</div>

@endsection
