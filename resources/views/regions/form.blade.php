@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('backend::region.name.0') }}"
    placeholder="{{ __('backend::region.name._') }}"
    {{-- helper="{{ __('backend::region.name.?') }}" --}} />

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend::regions.save')</button>
        <a href="{{ route('backend.regions') }}" class="btn btn-danger">@lang('backend::regions.cancel')</a>
    </div>
</div>
