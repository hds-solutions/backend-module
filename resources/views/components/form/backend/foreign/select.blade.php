<x-form-input-group {{ $attributes->only('prepend') }}>

    <x-form-foreign name="{{ $name }}"
        :resource="$resource"
        :values="$values"
        foreign="{{ $attributes->get('foreign', null) }}"
        foreign-add-label="{{ $attributes->get('foreign-add-label', null) }}"
        show="{{ $attributes->get('show', null) }}"
        filtered-by="{{ $attributes->get('filtered-by', null) }}"
        filtered-using="{{ $attributes->get('filtered-using', null) }}"
        append="{{ $attributes->get('append', null) }}"
        request="{{ $attributes->get('request', null) }}"
        {{ $attributes
            ->except([
                'foreign', 'foreign-add-label', 'show',
                'filtered-by', 'filtered-using',
                'append', 'request',

                'label', 'prepend' ]) }} />

</x-form-input-group>
