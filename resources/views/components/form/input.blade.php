<input name="{{ $name }}" {{ $attributes
    ->merge([
        'type' => 'text'
    ])
    ->class([
        'form-control',
        'is-invalid' => $attributes->has('error')
    ])->except('error') }} />
