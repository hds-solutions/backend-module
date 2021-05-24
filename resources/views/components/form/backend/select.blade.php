<x-form-row>
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    <x-form-row-group>

        <x-form-input-group {{ $attributes->only('prepend') }}>

            <x-form-select name="{{ $name }}" :values="$values"
                default="{{ $default() }}" {{ $attributes
                ->except([ 'label', 'default' , 'prepend' ]) }} />

        </x-form-input-group>

    </x-form-row-group>

    @include('backend::components.form.helper')

</x-form-row>
