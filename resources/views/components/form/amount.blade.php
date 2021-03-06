@if ($secondary)

    <div class="col-6 input-group">
        @if ($prepend)
        <div class="input-group-prepend">
            <div class="input-group-text">{{ $prepend }}</div>
        </div>
        @endif

        <input name="{{ $name }}" type="text" @if ($required) required @endif thousand
            value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
            class="form-control {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}">
    </div>

@else

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">{{ $label }}</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">

        <div class="form-row">

            <div class="@if ($slot->isEmpty()) col-12 @else col-6 @endif input-group">
                @if ($prepend)
                <div class="input-group-prepend">
                    <div class="input-group-text">{{ $prepend }}</div>
                </div>
                @endif

                <input name="{{ $name }}" type="text" @if ($required) required @endif thousand
                    value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
                    class="form-control {{ $errors->has($name) ? 'is-danger' : '' }}"
                    placeholder="{{ $placeholder }}">
            </div>

            @if ($slot->isNotEmpty()) {{ $slot }} @endif

        </div>
    </div>

    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif

</div>

@endif
