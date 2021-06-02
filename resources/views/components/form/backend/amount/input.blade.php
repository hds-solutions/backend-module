<x-form-input-group {{ $attributes->only('prepend') }}>

    <x-form-amount name="{{ $name }}"
        {{-- @if ($currency) data-currency-by="{{ $currency }}" @endif --}}
        {{-- @if ($errors->has($name)) error @endif --}}
        value="{{ old($name, isset($resource) ? ($resource?->$field ?? $default) : $default) }}"
        {{ $attributes
            ->merge([
                'data-currency-by'  => $currency ?? null,
                //FIXME: 'error'             => $errors->has($name) ? true : null,
            ])
            ->except([ 'prepend' ]) }} />

</x-form-input-group>
