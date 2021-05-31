<div class="row role-container mb-3" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif>
    <div class="col-12 d-flex">
        <x-form-foreign name="roles[]"
            :values="$roles"
            default="{{ $selected->id ?? null }}"

            {{-- foreign="" --}}
            {{-- foreign-add-label="products-catalog::roles.add" --}}

            label="products-catalog::product.roles.role_id.0"
            placeholder="products-catalog::product.roles.role_id._"
            {{-- helper="products-catalog::product.roles.role_id.?" --}}
            />
{{--
        <select name="roles[]"
            data-none-selected-text="@lang('products-catalog::product.roles.role_id._')"
            class="form-control selectpicker" placeholder="@lang('products-catalog::product.roles.role_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog::product.roles.role_id.0')</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}"
                @if (isset($selected) && !$old && $role->id == $selected->id ||
                    isset($old) && $role->id == $old)) selected @endif>{{ $role->name }}</option>
            @endforeach
        </select>
 --}}
        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Role')?"
            data-text="Esta seguro de eliminar la @lang('Role') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
</div>
