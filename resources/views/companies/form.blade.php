@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="ftid" required
    label="backend::company.ftid.0"
    placeholder="backend::company.ftid._"
    {{-- helper="backend::company.ftid.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="backend::company.name.0"
    placeholder="backend::company.name._"
    {{-- helper="backend::company.name.?" --}} />

<x-backend-form-image :resource="$resource ?? null" name="logo_id"
    :images="$images" data-live-search="true"

    label="backend::company.logo_id.0"
    placeholder="backend::company.logo_id.optional"
    {{-- helper="backend::company.logo_id.?" --}} />

<x-backend-form-controls
    submit="backend::companies.save"
    cancel="backend::companies.cancel" cancel-route="backend.companies" />
