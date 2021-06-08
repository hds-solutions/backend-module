<label {{ $attributes
    ->class([
        'control-label',
        'col-12 col-md-3 col-lg-2 mb-0 mt-2' => $attributes->has('form-label'),
])->except('form-label') }}>@lang($text)</label>
