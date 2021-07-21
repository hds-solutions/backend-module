@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="backend::region.name.0"
    placeholder="backend::region.name._"
    {{-- helper="backend::region.name.?" --}} />

<x-backend-form-controls
    submit="backend::regions.save"
    cancel="backend::regions.cancel" cancel-route="backend.regions" />
