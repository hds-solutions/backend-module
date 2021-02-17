@extends('backend::layouts.master')

@section('page-name', __('backend/user.title'))
@section('description', __('backend/user.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-table"></i>
                @lang('backend/user.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.users.create') }}"
                    class="btn btn-sm btn-primary">@lang('backend/user.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($resources->count())
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="w-100px">ID</th>
                            <th>@lang('backend/user.firstname')</th>
                            <th>@lang('backend/user.lastname')</th>
                            <th>@lang('backend/user.email')</th>
                            {{-- <th>Tipo</th> --}}
                            <th class="w-100px">@lang('backend.actions.title')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resources as $resource)
                        <tr>
                            <td>{{ $resource->getKey() }}</td>
                            <td>{{ $resource->firstname }}</td>
                            <td>{{ $resource->lastname ?? '--' }}</td>
                            <td>{{ $resource->email }}</td>
                            {{-- <td>{{ $resource->type }}</td> --}}
                            <td class="align-middle">
                                @include('backend::components.actions', [
                                    'resource'  => 'users',
                                    'title'     => $resource->name,
                                    'record'    => $resource->getKey(),
                                    'actions'   => [ 'update', 'delete' ]
                                ])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.users.create') }}" class="text-custom">
                        <ins>@lang('backend/user.add')</ins>
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>

@endsection