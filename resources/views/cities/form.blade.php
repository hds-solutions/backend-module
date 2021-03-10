@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="region_id" required
    foreign="regions" :values="$regions" foreign-add-label="{{ __('backend::regions.add') }}"

    label="{{ __('backend::city.region_id.0') }}"
    placeholder="{{ __('backend::city.region_id._') }}"
    {{-- helper="{{ __('backend::city.region_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::city.name.0') }}"
    placeholder="{{ __('backend::city.name._') }}"
    {{-- helper="{{ __('backend::city.name.?') }}" --}} />

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend::cities.save')</button>
        <a href="{{ route('backend.cities') }}" class="btn btn-danger">@lang('backend::cities.cancel')</a>
    </div>
</div>
