<x-form-row>
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    <x-form-row-group>

        <x-form-input-group {{ $attributes->only('prepend') }}>

            <x-form-input name="{{ $name }}" type="{{ $type ?? 'text' }}"
                value="{{ old($name, $resource->{$field} ?? null) }}"
                @if ($errors->has($name)) error="{{ $errors->first($name) }}" @endif
                {{ $attributes->except([ 'type', 'prepend' ]) }} />

        </x-form-input-group>

    </x-form-row-group>

    @include('backend::components.form.helper')

</x-form-row>
