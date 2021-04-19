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

<x-backend-form-controls
    submit="backend::cities.save"
    cancel="backend::cities.cancel" cancel-route="backend.cities" />
