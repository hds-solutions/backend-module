<input name="{{ $name }}"
    @if ($attributes->has('placeholder')) placeholder="@lang($attributes->get('placeholder', null))" @endif
    {{ $attributes->merge([
        'type' => 'text'
        ])->class([
            'form-control',
            'is-invalid' => $attributes->has('error')
        ])->except([ 'placeholder', 'error' ]) }} />

@if ($attributes->has('error'))
    <div class="invalid-feedback">{{ $attributes->get('error') }}</div>
@endif
