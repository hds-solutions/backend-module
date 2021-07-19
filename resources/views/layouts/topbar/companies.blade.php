@if (backend()->companies()->count() > 0)
<li class="nav-item dropdown no-arrow {{ backend()->company() ? 'mr-3' : '' }}">

    <a type="button" role="button"
        data-toggle="dropdown" href="#set-company" aria-haspopup="true" aria-expanded="false"
        {{-- data-toggle="modal" href="#company-selector" --}}
        class="nav-link dropdown-toggle text-dark px-1" id="companies-dropdown">
        <i class="fas fa-building fa-fw fa-2x text-{{ backend()->company() ? 'primary' : 'secondary' }} mr-2"></i>
        {{-- <span class="badge badge-danger badge-counter">7</span> --}}

        @if (backend()->company())
        <div class="">
            {{-- current company --}}
            <h5 class="m-0">{{ backend()->company()->name }}</h5>
            <div class="small text-gray-500">{{ ($branch = backend()->branch())?->name .($branch !== null ? ' · ' : null) . backend()->warehouse()?->name }}</div>
        </div>
        @endif
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="companies-dropdown">
        <h6 class="dropdown-header">
            @lang('Company selector')
        </h6>

        <a class="dropdown-item d-flex align-items-center" href="{{ route('backend.env', [ 'company_id' => 'null' ]) }}"
            {{-- data-toggle="modal" href="#company-selector" --}}>
            <div class="dropdown-list-image rounded-circle mr-3" style="background-image: url({{ asset('backend-module/assets/images/logo.png') }})">
                {{-- <img src="{{ asset('backend-module/assets/images/logo.png') }}"
                    class="rounded-circle"
                    alt="*"> --}}
                @if (backend()->company() == null)
                <div class="status-indicator bg-success"></div>
                @endif
            </div>
            <div @if (backend()->company() == null) class="font-weight-bold" @endif>
                <div class="text-truncate">*</div>
                {{-- <div class="small text-gray-500">some text · 58m</div> --}}
            </div>
        </a>

        @foreach(backend()->companies() as $company)
            <a class="dropdown-item d-flex align-items-center" {{-- href="{{ Request::fullUrlWithQuery([ 'set-company' => $company->getKey() ]) }}" --}}
                data-toggle="modal" href="#company-selector" data-company="{{ $company->id }}">
                <div class="dropdown-list-image rounded-circle mr-3" style="background-image: url({{ asset( $company->logo->url ?? 'backend-module/assets/images/default.jpg' ) }})">
                    {{-- <img src="{{ asset( $company->logo->url ?? 'backend-module/assets/images/default.jpg' ) }}"
                         class="rounded-circle mh-100px"
                         alt="{{ $company->name }}"> --}}
                    @if ($company->is_current)
                    <div class="status-indicator bg-success"></div>
                    @endif
                </div>
                <div @if ($company->is_current) class="font-weight-bold" @endif>
                    <div class="text-truncate">{{ $company->name }}</div>
                    {{-- <div class="small text-gray-500">some text · 58m</div> --}}
                </div>
            </a>
        @endforeach

    </div>

</li>
@endif
