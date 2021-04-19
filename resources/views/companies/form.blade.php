@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::company.name.0') }}"
    placeholder="{{ __('backend::company.name._') }}"
    {{-- helper="{{ __('backend::company.name.?') }}" --}} />

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="logo_id"
    label="{{ __('backend::company.logo_id.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::company.logo_id._') }}" />

<x-backend-form-controls
    submit="backend::companies.save"
    cancel="backend::companies.cancel" cancel-route="backend.companies" />
