<div class="col-12 d-flex mb-1">
    <x-form-foreign name="roles[]"
        :values="$roles" default="{{ $selected->id ?? null }}"

        foreign="roles" foreign-add-label="backend::roles.add"

        label="backend::user.roles.nav.0"
        placeholder="backend::user.roles.nav._"
        {{-- helper="backend::user.roles.nav.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Role')?"
        data-text="Esta seguro de eliminar la @lang('Role') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
