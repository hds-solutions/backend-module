<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">{{ $label }}</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="{{ $name }}" data-live-search="true" @if ($required) required @endif
            value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
            class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}">
            <option value="" selected @if ($required) disabled hidden @endif>{{ $label }}</option>
            @foreach($values as $value)
            <option value="{{ $value->id }}"
                @if (isset($resource) && !old($name) && $resource->$field == $value->id ||
                    old($name) == $value->id) selected @endif>{{ $value->name }}</option>
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