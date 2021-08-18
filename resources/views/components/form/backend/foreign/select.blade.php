<x-form-input-group {{ $attributes->only('prepend') }}>

    <x-form-foreign name="{{ $name }}"
        @if (isset($resource)) :resource="$resource" @endif
        :values="$values"
        @if ($default) default="{{ $default }}" @endif

        @if ($attributes->has('foreign')) :foreign="$attributes->get('foreign')" @endif
        @if ($attributes->has('foreign-add-label')) :foreign-add-label="$attributes->get('foreign-add-label')" @endif
        @if ($attributes->has('show')) :show="$attributes->get('show')" @endif
        @if ($attributes->has('filtered-by')) :filtered-by="$attributes->get('filtered-by')" @endif
        @if ($attributes->has('filtered-using')) :filtered-using="$attributes->get('filtered-using')" @endif
        @if ($attributes->has('append')) :append="$attributes->get('append')" @endif
        @if ($attributes->has('request')) :request="$attributes->get('request')" @endif

        @if ($errors->has($name)) error="{{ $errors->first($name) }}" @endif

        {{ $attributes->except([
            'foreign', 'foreign-add-label', 'show',
            'filtered-by', 'filtered-using',
            'append', 'request',

            'label', 'prepend' ]) }} />

</x-form-input-group>
