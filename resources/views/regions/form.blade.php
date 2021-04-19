@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::region.name.0') }}"
    placeholder="{{ __('backend::region.name._') }}"
    {{-- helper="{{ __('backend::region.name.?') }}" --}} />

<x-backend-form-controls
    submit="backend::regions.save"
    cancel="backend::regions.cancel" cancel-route="backend.regions" />
