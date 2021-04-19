@if ($secondary)

    <div class="col-12 col-md-9 mt-2 mt-xl-0 offset-md-3 offset-xl-0 col-xl-3">

        @include('backend::components.form.foreign.select')

    </div>

@else

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang($label)</label>
    <div class="@if ($slot->isEmpty()) col-11 col-md-8 col-lg-6 col-xl-4 @else col-12 col-md-9 col-xl-3 @endif">

        @include('backend::components.form.foreign.select')

    </div>

    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help"
            data-toggle="tooltip" data-placement="right"
            title="@lang($helper)"></i>
    </div>
    @endif

    @if ($slot->isNotEmpty()) {{ $slot }} @endif

</div>
@endif
