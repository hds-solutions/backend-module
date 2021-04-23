<select name="{{ $name }}" data-live-search="true" @if ($required) required @endif
    @if ($filteredBy) data-filtered-by="{{ $filteredBy }}" data-filtered-using="{{ $filteredUsing }}" @endif
    data-none-selected-text="{{ $placeholder }}"

    value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
    class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
    placeholder="@lang($placeholder)"

    @if ($foreign)
    data-foreign="{{ Str::snake($foreign) }}"
    data-form="{{ route('backend.'.Str::snake($foreign).'.create', [ 'only-form' ]) }}"
    data-fetch="{{ route('backend.'.Str::snake($foreign)) }}"
    @endif>

    <option value="" selected
        @if ($required) disabled hidden
        @else class="text-muted" @endif>@lang($placeholder)</option>

    @foreach ($values as $value)
    <option value="{{ $value->id }}"
        @if ($filteredBy) data-{{ $filteredUsing }}="{{ $value->{"{$filteredUsing}_id"} }}" @endif
        {{-- FIXME: old() > resouce > request > default --}}
        @if (isset($resource) && !old($name) && $resource->$field == $value->id ||
            old($name) == $value->id ||
            $request && request($request) == $value->id ||
            ($request && !request($request) && $value->id == $default)) selected @endif
        @foreach ($append as $appended) data-{{ $appended[0] }}="{{ $value->{$appended[1] ?? $appended[0]} }}" @endforeach
        >{{ data_get($value, $show) }}</option>
    @endforeach

    @if ($foreign)
    <option value="add::new"
        @if ($filteredBy) data-{{ $filteredUsing }}="*" @endif
        class="text-muted font-italic">@lang($foreignAddLabel ?? 'undefined')</option>
    @endif

</select>
