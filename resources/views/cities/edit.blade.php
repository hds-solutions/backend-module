@extends('backend::layouts.master')

@section('page-name', __('backend::cities.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-model-plus"></i>
                @lang('backend::cities.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.cities.create') }}"
                    class="btn btn-sm btn-primary">@lang('backend::cities.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.cities.update', $resource) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('backend::cities.form')
        </form>
    </div>
</div>

@endsection
