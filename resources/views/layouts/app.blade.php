<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- assets base path --}}
    <meta name="assets-path" content="{{ asset('/') }}">

    {{-- title --}}
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}"> --}}
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/180x180.png') }}"> --}}
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/32x32.png') }}"> --}}
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/16x16.png') }}"> --}}

    {{-- loader --}}
    <style type="text/css">.loader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background: #fff; }</style>
    {{-- styles --}}
    @include('backend::layouts.styles')
</head>
<body id="page-top" class="@yield('body-class', 'bg-white')">
    <div class="loader"></div>
    @yield('app')
    @include('backend::layouts.scripts')
</body>
</html>
