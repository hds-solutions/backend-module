@extends('backend::layouts.app')

@section('app')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @if (!request()->has('only-form'))
        @include('backend::layouts.sidebar')
        @endif
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @if (!request()->has('only-form'))
                @include('backend::layouts.topbar')
                @endif
                <!-- Begin Page Contents -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        @if (!request()->has('only-form'))
                        @hasSection('breadcrumb')
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                        @else
                        <h1 class="h3 mb-0 text-gray-800">@yield('page-name')</h1>
                        @endif
                        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                        @endif
                    </div>
                    @hasSection('description')
                    <div class="row">
                        <div class="col">
                            <p>@yield('description')</p>
                        </div>
                    </div>
                    @endif
                    <!-- Main Content -->
                    @yield('content')
                <!-- End Page Contents -->
                </div>
            <!-- End of Main Content -->
            </div>
            <!-- Footer -->
            @if (!request()->has('only-form'))
            @include('backend::layouts.footer')
            @endif
        <!-- End of Content Wrapper -->
        </div>
    <!-- End of Page Wrapper -->
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- modals --}}
    @include('backend::layouts.modals')
@endsection
