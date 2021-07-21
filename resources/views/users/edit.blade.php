@extends('backend::layouts.master')

@section('page-name', __('backend::users.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-user-plus mr-2"></i>
                @lang('backend::users.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.users.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('backend::users.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.users.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend::users.form')
        </form>
    </div>
</div>

@endsection
