<x-form-input-group {{ $attributes->only('prepend') }}>

    <x-form-amount name="{{ $name }}"
        @if ($currency) data-currency-by="{{ $currency }}" @endif
        @if ($errors->has($name)) error="{{ $errors->first($name) }}" @endif
        value="{{ old($name, isset($resource) ? ($resource?->$field ?? $default) : $default) }}"
        {{ $attributes->except([ 'prepend', 'label' ]) }} />

</x-form-input-group>
