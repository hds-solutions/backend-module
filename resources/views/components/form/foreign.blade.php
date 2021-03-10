@if ($secondary)

    <div class="col-12 col-md-9 mt-2 mt-xl-0 offset-md-3 offset-xl-0 col-xl-3">
        <select name="{{ $name }}"
            @if ($filteredBy) data-filtered-by="{{ $filteredBy }}" data-filtered-using="{{ $filteredUsing }}" @endif
            value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
            class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}"

            @if ($foreign)
            data-foreign="{{ $foreign }}"
            data-form="{{ route('backend.'.$foreign.'.create', [ 'only-form' ]) }}"
            data-fetch="{{ route('backend.'.$foreign.'') }}"
            @endif>

            <option value="" selected
                @if ($required) disabled hidden
                @else class="text-muted" @endif>{{ $placeholder }}</option>

            @foreach ($values as $value)
            <option value="{{ $value->id }}"
                @if ($filteredBy) data-{{ $filteredUsing }}="{{ $value->{"{$filteredUsing}_id"} }}" @endif
                @if (isset($resource) && !old($name) && $resource->$field == $value->id ||
                    old($name) == $value->id) selected @endif>{{ $value->name }}</option>
            @endforeach

            @if ($foreign)
            <option value="add::new"
                @if ($filteredBy) data-{{ $filteredUsing }}="*" @endif
                class="text-muted font-italic">{{ $foreignAddLabel ?? 'undefined' }}</option>
            @endif

        </select>
    </div>

@else

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">{{ $label }}</label>
    <div class="@if ($slot->isEmpty()) col-11 col-md-8 col-lg-6 col-xl-4 @else col-12 col-md-9 col-xl-3 @endif">

        <select name="{{ $name }}" data-live-search="true" @if ($required) required @endif
            value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}"
            class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}"

            @if ($foreign)
            data-foreign="{{ $foreign }}"
            data-form="{{ route('backend.'.$foreign.'.create', [ 'only-form' ]) }}"
            data-fetch="{{ route('backend.'.$foreign.'') }}"
            @endif>

            <option value="" selected
                @if ($required) disabled hidden
                @else class="text-muted" @endif>{{ $placeholder }}</option>

            @foreach ($values as $value)
            <option value="{{ $value->id }}"
                @if (isset($resource) && !old($name) && $resource->$field == $value->id ||
                    old($name) == $value->id ||
                    $request && request($request) == $value->id) selected @endif
                @foreach ($append as $appended) data-{{ $appended }}="{{ $value->{$appended.'_id'} }}" @endforeach>{{ $value->name }}</option>
            @endforeach

            @if ($foreign)
            <option value="add::new"
                class="text-muted font-italic">{{ $foreignAddLabel ?? 'undefined' }}</option>
            @endif

        </select>

    </div>

    @if ($help)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help"
            data-toggle="tooltip" data-placement="right"
            title="{{ $help }}"></i>
    </div>
    @endif

    @if ($slot->isNotEmpty()) {{ $slot }} @endif

</div>
@endif