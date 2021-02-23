<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a href="{{ route('backend.dashboard') }}" class="sidebar-brand d-flex flex-column align-items-center justify-content-center">
        @if (false)
            <div class="sidebar-brand-icon h-100 py-1 d-flex align-items-center">
                <img class="img-fluid h-50" src="{{ asset('assets/images/logo.png') }}">
            </div>
        @else
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
        @endif
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    {{-- load menu --}}
    @include('backend::layouts.menu', [ 'items' => Backend::menu()?->roots() ?? [] ])

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
