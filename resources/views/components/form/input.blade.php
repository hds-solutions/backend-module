<input name="{{ $name }}" {{ $attributes
    ->merge([
        'type' => 'text'
    ])
    ->class([
        'form-control',
        'is-invalid' => $attributes->has('error')
    ])->except('error') }} />

@if ($attributes->has('error'))
    <div class="invalid-feedback">{{ $attributes->get('error') }}</div>
@endif
