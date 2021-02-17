@extends('layouts.master')

@section('page-name', 'Editar Administrador')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                Editar Administrador
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-primary">Añadir</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.admins.update', $user->id) }}">
            @method('PUT')
            @csrf
            @include('admins.form')
        </form>
    </div>
</div>

@endsection