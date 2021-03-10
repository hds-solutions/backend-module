@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::company.name.0') }}"
    placeholder="{{ __('backend::company.name._') }}"
    {{-- helper="{{ __('backend::company.name.?') }}" --}} />

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="logo_id"
    label="{{ __('backend::company.logo_id.0') }}"
    placeholder="({{ __('optional') }}) {{ __('backend::company.logo_id._') }}" />

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend::companies.save')</button>
        <a href="{{ route('backend.companies') }}" class="btn btn-danger">@lang('backend::companies.cancel')</a>
    </div>
</div>
