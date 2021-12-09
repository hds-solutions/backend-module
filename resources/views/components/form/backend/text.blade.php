@if ($secondary)
    @include('backend::components.form.backend.text.input')

@else
    <x-form-row class="{{ $attributes->get('row-class') }}">
        <x-form-label text="{{ $attributes->get('label') }}" form-label />

        <x-form-row-group count="{{ $slot->isNotEmpty() ? 2 : 1 }}">
            @include('backend::components.form.backend.text.input')
        </x-form-row-group>

        @if ($slot->isNotEmpty())
        <x-form-row-group count="2" class="offset-md-3 offset-lg-2 offset-xl-0 mt-2 mt-xl-0">
            {{ $slot }}
        </x-form-row-group>
        @endif

        @include('backend::components.form.helper')

    </x-form-row>

@endif
