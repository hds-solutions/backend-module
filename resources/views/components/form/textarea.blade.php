<textarea name="{{ $name }}" {{ $attributes
    ->merge([
    ])
    ->class([
        'form-control resize-none',
        'wysiwyg'       => filter_var($attributes->get('wysiwyg', false), FILTER_VALIDATE_BOOLEAN),
        'is-invalid'    => $attributes->has('error'),
    ])->except([ 'error', 'wysiwyg', 'value' ]) }}>{{ $slot->isNotEmpty() ? $slot : $attributes->get('value') }}</textarea>
