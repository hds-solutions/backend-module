@if (Backend::companies()->count() > 1)
<li class="nav-item dropdown no-arrow mx-1">

    <button type="button" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="btn nav-link dropdown-toggle" id="companiesDropdown">
        <i class="fas fa-building fa-fw"></i>
        {{-- <span class="badge badge-danger badge-counter">7</span> --}}
    </button>

    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="companiesDropdown">
        <h6 class="dropdown-header">
            @lang('Company selector')
        </h6>

        @foreach(Backend::companies() as $company)
            <a class="dropdown-item d-flex align-items-center" href="{{ Request::fullUrlWithQuery([ 'set' => [ 'company' => $company->getKey() ]]) }}">
                <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="{{ $company->name }}">
                    @if ($company->isCurrent)
                    <div class="status-indicator bg-success"></div>
                    @endif
                </div>
                <div @if ($company->isCurrent) class="font-weight-bold" @endif>
                    <div class="text-truncate">{{ $company->name }}</div>
                    {{-- <div class="small text-gray-500">some text · 58m</div> --}}
                </div>
            </a>
        @endforeach

    </div>

</li>
@endif