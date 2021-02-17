@extends('layouts.master')

@section('page-name', 'Crear nuevo Administrador')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                Añadir Administrador
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('admins.create') }}" class="btn btn-sm btn-primary">Añadir</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf
            @include('admins.form')
        </form>
    </div>
</div>

@endsection