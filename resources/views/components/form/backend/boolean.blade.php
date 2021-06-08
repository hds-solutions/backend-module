<x-form-row>
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    <x-form-row-group>

        <x-form-input-group {{ $attributes->only('prepend') }}>
            <x-form-boolean name="{{ $name }}"
                value="{{ (isset($resource) && !old($name) ? $resource->$field : old($name)) ? 'true' : 'false' }}"
                @if ($errors->has($name)) error="{{ $errors->first($name) }}" @endif
                class="form-control"
                {{ $attributes->except([ 'label', 'class' ]) }} />
        </x-form-input-group>

    </x-form-row-group>

    @include('backend::components.form.helper')

</x-form-row>
