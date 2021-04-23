@if (backend()->currencies()->count() > 0)
<li class="nav-item dropdown no-arrow mx-1">

    <a href="#set-currency" type="button" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="nav-link dropdown-toggle text-dark px-1" id="currenciesDropdown">
        <i class="fas fa-coins fa-fw text-primary"></i>
        {{-- <span class="badge badge-danger badge-counter">7</span> --}}

        {{-- current currency --}}
        <h5 class="m-0 ml-2">{{ backend()->currency()->name }}</h5>
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="currenciesDropdown">
        <h6 class="dropdown-header">
            @lang('Currency selector')
        </h6>

        @foreach(backend()->currencies() as $currency)
            <a class="dropdown-item d-flex align-items-center" href="{{ Request::fullUrlWithQuery([ 'set-currency' => $currency->getKey() ]) }}">
                <div class="dropdown-list-image rounded-circle d-flex align-items-center justify-content-center mr-3 bg-warning @if ($currency->isCurrent) font-weight-bold @endif">
                    {{-- <img src="{{ asset( $currency->logo->url ?? 'backend-module/assets/images/default.jpg' ) }}"
                         class="rounded-circle mh-100px"
                         alt="{{ $currency->name }}"> --}}
                         {{ $currency->code }}
                    @if ($currency->isCurrent)
                    <div class="status-indicator bg-success"></div>
                    @endif
                </div>
                <div @if ($currency->isCurrent) class="font-weight-bold" @endif>
                    <div class="text-truncate">{{ $currency->name }}</div>
                    {{-- <div class="small text-gray-500">some text · 58m</div> --}}
                </div>
            </a>
        @endforeach

    </div>

</li>
@endif
