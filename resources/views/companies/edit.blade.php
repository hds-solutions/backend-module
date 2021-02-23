@extends('backend::layouts.master')

@section('page-name', __('backend/company.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-company-plus"></i>
                @lang('backend/company.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.companies.create') }}" class="btn btn-sm btn-primary">@lang('backend/company.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.companies.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('backend::companies.form')
        </form>
    </div>
</div>

@endsection