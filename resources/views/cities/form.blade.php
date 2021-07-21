@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="region_id" required
    foreign="regions" :values="$regions" foreign-add-label="backend::regions.add"
    data-live-search="true"

    label="backend::city.region_id.0"
    placeholder="backend::city.region_id._"
    {{-- helper="backend::city.region_id.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="backend::city.name.0"
    placeholder="backend::city.name._"
    {{-- helper="backend::city.name.?" --}} />

<x-backend-form-controls
    submit="backend::cities.save"
    cancel="backend::cities.cancel" cancel-route="backend.cities" />
