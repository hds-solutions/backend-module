@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="company_id" required
    foreign="companies" :values="$companies" foreign-add-label="{{ __('backend::companies.add') }}"

    label="{{ __('backend::branch.company_id.0') }}"
    placeholder="{{ __('backend::branch.company_id._') }}"
    {{-- helper="{{ __('backend::branch.company_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::branch.name.0') }}"
    placeholder="{{ __('backend::branch.name._') }}"
    {{-- helper="{{ __('backend::branch.name.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="code"
    label="{{ __('backend::branch.code.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.code._') }}"
    {{-- helper="{{ __('backend::branch.code.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="phone"
    label="{{ __('backend::branch.phone.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.phone._') }}"
    {{-- helper="{{ __('backend::branch.phone.?') }}" --}} />

<x-backend-form-foreign :resource="$resource ?? null" name="region_id" required
    foreign="regions" :values="$regions" foreign-add-label="{{ __('backend::regions.add') }}"

    label="{{ __('backend::branch.region_id.0') }} / {{ __('backend::branch.city_id.0') }}"
    placeholder="{{ __('backend::branch.region_id.optional') }}"
    {{-- helper="{{ __('backend::branch.region_id.?') }}" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="city_id" required
        filtered-by="[name=region_id]" filtered-using="region"
        foreign="cities" :values="$regions->pluck('cities')->flatten()" foreign-add-label="{{ __('backend::cities.add') }}"

        label="{{ __('backend::branch.city_id.0') }}"
        placeholder="{{ __('backend::branch.city_id.optional') }}"
        {{-- helper="{{ __('backend::branch.city_id.?') }}" --}} />

</x-backend-form-foreign>

<x-backend-form-text :resource="$resource ?? null" name="district"
    label="{{ __('backend::branch.district.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.district._') }}"
    {{-- helper="{{ __('backend::branch.district.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="address" required
    label="{{ __('backend::branch.address.0') }}"
    placeholder="{{ __('backend::branch.address._') }}"
    {{-- helper="{{ __('backend::branch.address.?') }}" --}} />

<x-backend-form-coords :resource="$resource ?? null"
    {{-- label="{{ __('backend::branch.coords.0') }}" --}}
    {{-- placeholder="{{ __('backend::branch.coords._') }}" --}}
    {{-- helper="{{ __('backend::branch.coords.?') }}" --}} />

<x-backend-form-controls
    submit="backend::branches.save"
    cancel="backend::branches.cancel" cancel-route="backend.branches" />

@push('pre-scripts')
    @gmap
@endpush
