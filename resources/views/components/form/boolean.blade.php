<div {{ $attributes->class('form-check')->except([ 'value', 'type' ]) }}>
    <input name="{{ $name }}" type="hidden"
        value="{{ filter_var($attributes->get('value', false), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }}" />
    <input name="{{ $name }}-checkbox" type="checkbox" id="{{ $booleanId = Str::slug($name.'-'.Str::random()) }}"
        onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
        class="form-check-input @if ($attributes->has('error')) is-invalid @endif"
        @if (filter_var($attributes->get('value', false), FILTER_VALIDATE_BOOLEAN)) checked @endif
        {{ $attributes->except([ 'type', 'class', 'error' ]) }} />
    <label for="{{ $booleanId }}" class="form-check-label">@lang($attributes->get('placeholder', null))</label>

    @if ($attributes->has('error'))
        <div class="invalid-feedback">{{ $attributes->get('error') }}</div>
    @endif
</div>
