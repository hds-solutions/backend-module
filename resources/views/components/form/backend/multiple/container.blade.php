<div class="{{ $attributes->get('row-type', 'form-row') }} {{ $singular }}-container {{ $attributes->get('container-class') }}"
    @if ($selected === null && $old === null) id="new" @endif
    @if (!$autoAddLines || $selected !== null || $old !== null) data-used="true" @endif>

    @include($contentsView, [
        $valuesAs ?? $name  => $values,
        $extraAs ?? 'extra' => $extra ?? null,
        'selected'          => $selected,
        'old'               => $old,
    ])

</div>
