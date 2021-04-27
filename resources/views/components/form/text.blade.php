<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">{{ $label }}</label>
    <div class="col-11 col-md-8 col-lg-6 @if (!$fullWidth) col-xl-4 @endif">
        <div class="input-group">
            @if ($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prepend }}</div>
            </div>
            @endif

            <input name="{{ $name }}" type="{{ $type ?? 'text' }}" @if ($required) required @endif
                value="{{ isset($resource) && !old($name) ? $resource->$field : old($name, $default) }}"
                class="form-control {{ $errors->has($name) ? 'is-danger' : '' }}"
                placeholder="{{ $placeholder }}">
        </div>
    </div>

    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif

</div>
