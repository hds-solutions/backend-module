<x-form-input name="{{ $name }}" type="time"
    @if ($attributes->has('placeholder')) placeholder="@lang($attributes->get('placeholder', null))" @endif
    {{ $attributes->except([ 'type', 'placeholder' ]) }} />
