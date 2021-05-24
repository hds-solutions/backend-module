<select name="{{ $name }}" {{ $attributes
    ->class([
        'form-control selectpicker',
        'is-invalid' => $attributes->has('error')
    ])->except('placeholder') }}
    @if ($attributes->has('placeholder')) data-none-selected-text="@lang($attributes->get('placeholder'))" @endif>

    @if ($attributes->has('placeholder'))
    <option value="" selected
        @if ($attributes->has('required') || $values->has('')) disabled hidden
        @else class="text-muted" @endif>@lang($values[''] ?? $attributes->get('placeholder'))</option>
    @endif

    @foreach($values as $idx => $value)
    <option value="{{ $idx }}"
        @if ($isSelected($idx)) selected @endif>
        @lang($value)
    </option>
    @endforeach

</select>
