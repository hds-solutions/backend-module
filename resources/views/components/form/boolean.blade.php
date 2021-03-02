<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">{{ $label }}</label>
    <div class="col-3">
        <div class="form-check">
            <input type="hidden" name="{{ $name }}"
                value="{{ (isset($resource) && !old($name) ? $resource->$field : old($name)) ? 'true' : 'false' }}">
            <input type="checkbox" id="{{ $field }}"
                onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
                @if (isset($resource) && !old($name) ? $resource->$field : old($name)) checked @endif
                class="form-check-input {{ $errors->has($name) ? 'is-danger' : '' }}"
                placeholder="{{ $placeholder }}">
            <label for="{{ $field }}" class="form-check-label">{{ $placeholder }}</label>
        </div>
    </div>
    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif
</div>