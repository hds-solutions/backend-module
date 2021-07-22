@extends('backend::layouts.master')

@section('page-name', __('backend::companies.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-company-plus"></i>
                @lang('backend::companies.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.companies.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('backend::companies.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.companies.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend::companies.form')
        </form>
    </div>
</div>

@endsection
