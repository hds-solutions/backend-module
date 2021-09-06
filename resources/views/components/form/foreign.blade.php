<select name="{{ $name }}" {{ $attributes
    ->class([
        'form-control selectpicker',
        'is-invalid' => $attributes->has('error')
    ])
    ->merge([
        'data-show' => $show,
    ])
    ->except([ 'placeholder' ]) }}
    @if ($filteredBy) data-filtered-by="{{ $filteredBy }}" data-filtered-using="{{ $filteredUsing }}" @endif
    @if ($attributes->has('placeholder')) data-none-selected-text="@lang($attributes->get('placeholder'))" @endif

    @if ($foreign)
    data-foreign="{{ Str::snake($foreign) }}"
    data-form="{{ route('backend.'.Str::snake($foreign).'.create', [ 'only-form' => 'true' ]) }}"
    data-fetch="{{ route('backend.'.Str::snake($foreign)) }}"
    @endif>

    {{-- @if ($attributes->has('placeholder')) --}}
    <option value="" selected
        @if ($attributes->has('required') || $values->has('')) disabled hidden
        @else class="text-muted" @endif>@lang($values[''] ?? $attributes->get('placeholder'))</option>
    {{-- @endif --}}

    @foreach ($values as $value)
    <option value="{{ $value->id }}"
        @if ($title) title="{!! $parseShow($value, 'title') !!}" @endif
        @if ($subtext) data-subtext="{!! $parseShow($value, 'subtext') !!}" @endif
        @if ($isSelected($value)) selected @endif
        @foreach ($append as $appended) data-{{ $appended[0] }}="{{ data_get($value, $appended[1] ?? $appended[0], $appended[2] ?? null) }}" @endforeach
        >{!! $parseShow($value) !!}</option>
    @endforeach

    @if ($foreign)
    <option value="add::new"
        @if ($filteredBy) data-{{ $filteredUsing }}="*" @endif
        class="text-muted font-italic">@lang($foreignAddLabel ?? 'undefined')</option>
    @endif

</select>

@if ($attributes->has('error'))
    <div class="invalid-feedback">{{ $attributes->get('error') }}</div>
@endif
