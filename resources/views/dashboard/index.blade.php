@extends('backend::layouts.master')

@section('page-name', 'Dashboard')

@section('content')

    @if (config('app.debug'))
        @include('backend::layouts.examples')
    @endif

@endsection
