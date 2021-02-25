<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav">
        <!-- Nav Item - Companies selector -->
        @include('backend::layouts.topbar.companies')
    </ul>

    {{-- current company --}}
    <h5 class="m-0">{{ Backend::company()->name }}</h5>

    <!-- Topbar Search -->
    {{-- @include('backend::layouts.topbar.search') --}}

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        {{-- @include('layouts.search-xs') --}}

        <!-- Nav Item - Alerts -->
        {{-- @include('backend::layouts.topbar.alerts') --}}

        <!-- Nav Item - Messages -->
        {{-- @include('backend::layouts.topbar.messages') --}}

        <!-- divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        @include('backend::layouts.topbar.user')

    </ul>

</nav>