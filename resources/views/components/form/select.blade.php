<div class="form-row form-group d-flex align-items-center">
    <label class="col-12 col-md-3 control-label m-0">{{ $label }}</label>
    <div class="col-12 col-md-9 col-xl-3">
        <select name="{{ $name }}" @if ($required) required @endif
            class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}">
            <option value="" selected @if ($required) disabled hidden @endif>{{ $label }}</option>
            @foreach($values as $idx => $value)
            <option value="{{ $idx }}"
                @if (isset($resource) && !old($name) && $resource->$field == $idx ||
                    old($name) == $idx || (!isset($resource) && !old($name) && $idx == $default)) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif
</div>