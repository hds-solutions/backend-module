<div {{ $attributes->merge([ 'class' => 'form-row form-group align-items-center' ]) }}>
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">{{ $label }}</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">

        <div class="form-control form-check pl-2">

            @foreach($values as $idx => $value)
            <div class="form-check form-check-inline">
                <input name="{{ $name }}" type="radio" @if ($required) required @endif
                    value="{{ $idx }}"
                    @if ($resource !== null && !old($name) && $resource->$field == $idx ||
                        old($name) === $idx ||
                        $resource === null && !old($name) && $idx === $default) checked @endif
                    id="{{ $optionId = Str::slug($field.'::'.$value) }}"
                    class="form-check-input">
                <label class="form-check-label" for="{{ $optionId }}">@lang($value)</label>
            </div>
            @endforeach

        </div>

    </div>
    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif
</div>
