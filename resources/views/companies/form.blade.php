@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/company.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/company.name._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/company.name.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/company.name.?')</label> --}}
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend/company.save')</button>
        <a href="{{ route('backend.companies') }}" class="btn btn-danger">@lang('backend/company.cancel')</a>
    </div>
</div>
