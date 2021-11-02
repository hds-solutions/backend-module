@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="company_id" required
    foreign="companies" :values="$companies" foreign-add-label="backend::companies.add"
    :default="backend()->company()?->id" :readonly="backend()->branchScoped()"

    label="backend::branch.company_id.0"
    placeholder="backend::branch.company_id._"
    {{-- helper="backend::branch.company_id.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="backend::branch.name.0"
    placeholder="backend::branch.name._"
    {{-- helper="backend::branch.name.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="code"
    label="backend::branch.code.0"
    placeholder="backend::branch.code.optional"
    {{-- helper="backend::branch.code.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="phone"
    label="backend::branch.phone.0"
    placeholder="backend::branch.phone.optional"
    {{-- helper="backend::branch.phone.?" --}} />

<x-backend-form-foreign :resource="$resource ?? null" name="region_id" required
    foreign="regions" :values="$regions" foreign-add-label="backend::regions.add"
    data-live-search="true"

    label="{{ __('backend::branch.region_id.0') }} / {{ __('backend::branch.city_id.0') }}"
    placeholder="backend::branch.region_id._"
    {{-- helper="backend::branch.region_id.?" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="city_id" secondary required
        foreign="cities" :values="$regions->pluck('cities')->flatten()" foreign-add-label="backend::cities.add"
        data-live-search="true" filtered-by="[name=region_id]" filtered-using="region"

        label="backend::branch.city_id.0"
        placeholder="backend::branch.city_id._"
        {{-- helper="backend::branch.city_id.?" --}} />

</x-backend-form-foreign>

<x-backend-form-text :resource="$resource ?? null" name="district"
    label="backend::branch.district.0"
    placeholder="backend::branch.district.optional"
    {{-- helper="backend::branch.district.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="address" required
    label="backend::branch.address.0"
    placeholder="backend::branch.address._"
    {{-- helper="backend::branch.address.?" --}} />

<x-backend-form-coords :resource="$resource ?? null"
    {{-- label="backend::branch.coords.0" --}}
    {{-- placeholder="backend::branch.coords._" --}}
    {{-- helper="backend::branch.coords.?" --}} />

<x-backend-form-controls
    submit="backend::branches.save"
    cancel="backend::branches.cancel" cancel-route="backend.branches" />

@push('pre-scripts')
    @gmap
@endpush
