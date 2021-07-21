@include('backend::components.errors')

<x-backend-form-text name="firstname" required
    :resource="$resource ?? null"
    label="backend::user.firstname.0"
    placeholder="backend::user.firstname._"
    {{-- helper="backend::user.firstname.?" --}} />

<x-backend-form-text name="lastname"
    :resource="$resource ?? null"
    label="backend::user.lastname.0"
    placeholder="backend::user.lastname._"
    {{-- helper="backend::user.lastname.?" --}} />

<x-backend-form-email name="email" required
    :resource="$resource ?? null"
    label="backend::user.email.0"
    placeholder="backend::user.email._"
    {{-- helper="backend::user.email.?" --}} />

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang('backend::user.password.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="password" type="password" @if (!isset($resource)) required @endif
            value="" autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::user.password._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend::user.password.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend::user.password.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang('backend::user.password.confirm')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="password_confirmation" type="password" @if (!isset($resource)) required @endif
            value="" autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::user.password.confirm_')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend::user.password.confirm?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('backend::user.password.confirm?')</label> --}}
</div>

<x-backend-form-multiple name="roles"
    :values="$roles" :selecteds="isset($resource) ? $resource->roles : []"
    contents-view="backend::users.form.role"

    label="backend::users.roles.0" />

<x-backend-form-controls
    submit="backend::users.save"
    cancel="backend::users.cancel" cancel-route="backend.users" />
