@if (backend()->companies()->count() > 0)
<li class="nav-item dropdown no-arrow mx-1">

    <a href="#set-company" type="button" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="nav-link dropdown-toggle text-dark px-1" id="companiesDropdown">
        <i class="fas fa-building fa-fw text-primary"></i>
        {{-- <span class="badge badge-danger badge-counter">7</span> --}}

        {{-- current company --}}
        <h5 class="m-0 ml-2">{{ backend()->company()->name }}</h5>
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="companiesDropdown">
        <h6 class="dropdown-header">
            @lang('Company selector')
        </h6>

        <a class="dropdown-item d-flex align-items-center" href="{{ Request::fullUrlWithQuery([ 'set-company' => 'null' ]) }}">
            <div class="dropdown-list-image rounded-circle mr-3" style="background-image: url({{ asset('backend-module/assets/images/logo.png') }})">
                {{-- <img src="{{ asset('backend-module/assets/images/logo.png') }}"
                    class="rounded-circle"
                    alt="*"> --}}
                @if (backend()->company()->getKey() == null)
                <div class="status-indicator bg-success"></div>
                @endif
            </div>
            <div @if (backend()->company()->getKey() == null) class="font-weight-bold" @endif>
                <div class="text-truncate">*</div>
                {{-- <div class="small text-gray-500">some text · 58m</div> --}}
            </div>
        </a>

        @foreach(backend()->companies() as $company)
            <a class="dropdown-item d-flex align-items-center" href="{{ Request::fullUrlWithQuery([ 'set-company' => $company->getKey() ]) }}">
                <div class="dropdown-list-image rounded-circle mr-3" style="background-image: url({{ asset( $company->logo->url ?? 'backend-module/assets/images/default.jpg' ) }})">
                    {{-- <img src="{{ asset( $company->logo->url ?? 'backend-module/assets/images/default.jpg' ) }}"
                         class="rounded-circle mh-100px"
                         alt="{{ $company->name }}"> --}}
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
