<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    {{-- @include('layouts.search') --}}

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        {{-- @include('layouts.search-xs') --}}

        <!-- Nav Item - Alerts -->
        {{-- @include('layouts.alerts') --}}

        <!-- Nav Item - Messages -->
        {{-- @include('layouts.messages') --}}

        {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

        <!-- Nav Item - User Information -->
        @include('backend::layouts.user')

    </ul>

</nav>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Cerrar Sesión?</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Estas seguro de finalizar tu sesión?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{ route('backend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Si, salir</a>
                <form method="POST" action="{{ route('backend.logout') }}" class="d-none" id="logout-form">@csrf</form>
            </div>
        </div>
    </div>
</div>