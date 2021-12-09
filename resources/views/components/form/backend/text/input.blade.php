<x-form-input-group {{ $attributes->only('prepend') }}>

    <x-form-input name="{{ $name }}" type="{{ $type ?? 'text' }}"
        value="{{ old($name, $resource->{$field} ?? $default ?? null) }}"
        @if ($errors->has($name)) error="{{ $errors->first($name) }}" @endif
        {{ $attributes->except([ 'type', 'prepend' ]) }} />

</x-form-input-group>
