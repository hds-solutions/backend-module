<div class="col-12 d-flex mb-1">
    <x-form-foreign name="companies[]"
        :values="$companies" default="{{ $selected->id ?? null }}"

        foreign="companies" foreign-add-label="backend::companies.add"

        label="backend::user.companies.0"
        placeholder="backend::user.companies._"
        {{-- helper="backend::user.companies.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Company')?"
        data-text="Esta seguro de eliminar la @lang('Company') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
