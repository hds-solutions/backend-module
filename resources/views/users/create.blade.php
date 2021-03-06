@extends('backend::layouts.master')

@section('page-name', __('backend::users.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                @lang('backend::users.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.users.create') }}" class="btn btn-sm btn-primary">@lang('backend::users.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.users.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('backend::users.form')
        </form>
    </div>
</div>

@endsection