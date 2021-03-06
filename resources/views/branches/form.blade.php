@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="company_id" required
    foreign="companies" :values="$companies" foreign-add-label="{{ __('backend::companies.add') }}"

    label="{{ __('backend::branch.company_id.0') }}"
    placeholder="{{ __('backend::branch.company_id._') }}"
    {{-- help="{{ __('backend::branch.company_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::branch.name.0') }}"
    placeholder="{{ __('backend::branch.name._') }}"
    {{-- help="{{ __('backend::branch.name.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="code"
    label="{{ __('backend::branch.code.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.code._') }}"
    {{-- help="{{ __('backend::branch.code.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="phone"
    label="{{ __('backend::branch.phone.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.phone._') }}"
    {{-- help="{{ __('backend::branch.phone.?') }}" --}} />

<x-backend-form-foreign :resource="$resource ?? null" name="region_id" required
    foreign="regions" :values="$regions" foreign-add-label="{{ __('backend::regions.add') }}"

    label="{{ __('backend::branch.region_id.0') }} / {{ __('backend::branch.city_id.0') }}"
    placeholder="{{ __('backend::branch.region_id.optional') }}"
    {{-- help="{{ __('backend::branch.region_id.?') }}" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="city_id" required
        filtered-by="[name=region_id]" filtered-using="region"
        foreign="cities" :values="$regions->pluck('cities')->flatten()" foreign-add-label="{{ __('backend::cities.add') }}"

        label="{{ __('backend::branch.city_id.0') }}"
        placeholder="{{ __('backend::branch.city_id.optional') }}"
        {{-- help="{{ __('backend::branch.city_id.?') }}" --}} />

</x-backend-form-foreign>

<x-backend-form-text :resource="$resource ?? null" name="district"
    label="{{ __('backend::branch.district.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::branch.district._') }}"
    {{-- help="{{ __('backend::branch.district.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="address" required
    label="{{ __('backend::branch.address.0') }}"
    placeholder="{{ __('backend::branch.address._') }}"
    {{-- help="{{ __('backend::branch.address.?') }}" --}} />

<x-backend-form-coords :resource="$resource ?? null"
    {{-- label="{{ __('backend::branch.coords.0') }}" --}}
    {{-- placeholder="{{ __('backend::branch.coords._') }}" --}}
    {{-- help="{{ __('backend::branch.coords.?') }}" --}} />

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend::branches.save')</button>
        <a href="{{ route('backend.branches') }}" class="btn btn-danger">@lang('backend::branches.cancel')</a>
    </div>
</div>
