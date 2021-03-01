@extends('backend::layouts.master')

@section('page-name', __('backend/file.title'))
@section('description', __('backend/file.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-table"></i>
                @lang('backend/file.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.files.create') }}"
                    class="btn btn-sm btn-primary">@lang('backend/file.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($count)
            <div class="table-responsive">
                {{
                    $dataTable->table()
                    /*
                    $dataTable->table([
                        'class'         => 'table table-bordered',
                        'data-route'    => route('backend.files'),
                        'data-columns'  => $dataTable->getColumns()->map(fn($item) => [ 'data' => $item->data])->toJson(),
                    ])
                    */
                }}

                @include('backend::components.datatable-actions', [
                    'actions'   => [ 'delete' ]
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.files.create') }}" class="text-custom">
                        <ins>@lang('backend/file.add')</ins>
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('config-scripts')
{{ $dataTable->scripts() }}
@endpush