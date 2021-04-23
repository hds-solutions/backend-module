@extends('backend::layouts.master')

@section('page-name', __('backend::regions.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-company-plus"></i>
                @lang('backend::regions.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.regions.create') }}"
                    class="btn btn-sm btn-primary">@lang('backend::companieies.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.regions.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('backend::regions.form')
        </form>
    </div>
</div>

@endsection
