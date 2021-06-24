<div class="{{ $attributes->get('row-type', 'form-row') }} {{ $singular }}-container {{ $attributes->get('container-class') }}" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif>

    @include($contentsView, [
        $valuesAs ?? $name  => $values,
        $extraAs ?? $name   => $extra,
        'selected'          => $selected,
        'old'               => $old,
    ])

</div>
