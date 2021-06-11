<x-form-input name="{{ $name }}" type="{{ $type ?? 'date' }}" daterangepicker
    @if ($attributes->has('placeholder')) placeholder="@lang($attributes->get('placeholder', null))" @endif
    {{ $attributes->except([ 'type', 'placeholder' ]) }} />
