<x-form-row>
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    <x-form-row-group>

        <x-form-input-group {{ $attributes->only('prepend') }}>
            <x-form-text-area name="{{ $name }}"
                {{ $attributes->except([ 'prepend', 'default' ]) }}>

                {{ $resource->{$field} ?? ($slot->isNotEmpty() ? $slot : $attributes->get('default')) }}

            </x-form-text-area>
        </x-form-input-group>

    </x-form-row-group>

    @include('backend::components.form.helper')

</x-form-row>
