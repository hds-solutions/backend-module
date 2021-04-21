<div class="form-row form-group d-flex align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang($label)</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="{{ $name }}" @if ($required) required @endif
            class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="@lang($placeholder)" data-none-selected-text="@lang($placeholder)">

            <option value="" selected @if ($required || $values->contains('')) disabled hidden @endif>@lang($values[''] ?? $label)</option>

            @foreach($values as $idx => $value)
            <option value="{{ $idx }}"
                @if ($resource !== null && !old($name) && $resource->$field == $idx ||
                    old($name) === $idx ||
                    $resource === null && !old($name) && $idx === $default) selected @endif>@lang($value)</option>
            @endforeach
        </select>
    </div>

    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang($helper)"></i>
    </div>
    @endif
</div>
