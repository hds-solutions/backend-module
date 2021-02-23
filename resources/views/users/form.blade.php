@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/user.firstname.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="firstname" type="text" required
            value="{{ isset($resource) && !old('firstname') ? $resource->firstname : old('firstname') }}"
            class="form-control {{ $errors->has('firstname') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/user.firstname._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/user.firstname.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/user.firstname.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/user.lastname.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="lastname" type="text"
            value="{{ isset($resource) && !old('lastname') ? $resource->lastname : old('lastname') }}"
            class="form-control {{ $errors->has('lastname') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/user.lastname._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/user.lastname.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/user.lastname.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/user.email.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="email" type="email" required
            value="{{ isset($resource) && !old('email') ? $resource->email : old('email') }}"
            class="form-control {{ $errors->has('email') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/user.email._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/user.email.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/user.email.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/user.password.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="password" type="password" @if (!isset($resource)) required @endif
            value="" autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/user.password._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/user.password.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/user.password.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend/user.password.confirm')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="password_confirmation" type="password" @if (!isset($resource)) required @endif
            value="" autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}"
            placeholder="@lang('backend/user.password.confirm_')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend/user.password.confirm?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend/user.password.confirm?')</label> --}}
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('backend/user.save')</button>
        <a href="{{ route('backend.users') }}" class="btn btn-danger">@lang('backend/user.cancel')</a>
    </div>
</div>
