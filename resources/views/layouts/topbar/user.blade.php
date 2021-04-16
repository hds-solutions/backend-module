<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ (auth()->user()->lastname ? auth()->user()->lastname.', ' : '').auth()->user()->firstname }}</span>
        <img class="img-profile rounded-circle" src="{{ asset('backend-module/assets/images/no-profile-photo.jpg') }}">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery([ 'locale' => 'es' ]) }}">
            <i class="fas fa-flag fa-sm fa-fw mr-2 text-gray-400"></i>
            <span class="@if (app()->getLocale() == 'es') font-weight-bold @endif">Español</span>
        </a>
        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery([ 'locale' => 'en' ]) }}">
            <i class="fas fa-flag fa-sm fa-fw mr-2 text-gray-400"></i>
            <span class="@if (app()->getLocale() == 'en') font-weight-bold @endif">English</span>
        </a>

        {{--
        <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
        </a>
        <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
        </a> --}}

        <div class="dropdown-divider"></div>

        <form method="POST" action="{{ route('backend.logout') }}">
            @csrf

            <button type="submit"
                href="{{ route('backend.logout') }}"
                data-confirm="@lang('Logout')?"
                data-text="@lang('Are you sure you want to log out')?"
                data-accept="@lang('Yes, logout')"
                class="dropdown-item">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                @lang('Logout')
            </button>
        </form>

    </div>
</li>
