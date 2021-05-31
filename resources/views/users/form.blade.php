@include('backend::components.errors')

<x-backend-form-text name="firstname" required
    :resource="$resource ?? null"
    label="backend::user.firstname.0"
    placeholder="backend::user.firstname._"
    {{-- helper="backend::user.firstname.?" --}} />
{{--
<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend::user.firstname.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="firstname" type="text" required
            value="{{ isset($resource) && !old('firstname') ? $resource->firstname : old('firstname') }}"
            class="form-control {{ $errors->has('firstname') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::user.firstname._')">
    </div>
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend::user.firstname.?')"></i>
    </div>
    <label class="col-12 control-label small">@lang('backend::user.firstname.?')</label>
</div>
 --}}

<x-backend-form-text name="lastname"
    :resource="$resource ?? null"
    label="backend::user.lastname.0"
    placeholder="backend::user.lastname._"
    {{-- helper="backend::user.lastname.?" --}} />
{{--
<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend::user.lastname.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="lastname" type="text"
            value="{{ isset($resource) && !old('lastname') ? $resource->lastname : old('lastname') }}"
            class="form-control {{ $errors->has('lastname') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::user.lastname._')">
    </div>
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend::user.lastname.?')"></i>
    </div>
    <label class="col-12 control-label small">@lang('backend::user.lastname.?')</label>
</div>
 --}}

<x-backend-form-email name="email" required
    :resource="$resource ?? null"
    label="backend::user.email.0"
    placeholder="backend::user.email._"
    {{-- helper="backend::user.email.?" --}} />
{{--
<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend::user.email.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="email" type="email" required
            value="{{ isset($resource) && !old('email') ? $resource->email : old('email') }}"
            class="form-control {{ $errors->has('email') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::user.email._')">
    </div>
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('backend::user.email.?')"></i>
    </div>
    <label class="col-12 control-label small">@lang('backend::user.email.?')</label>
</div>
 --}}

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

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 col-lg-2 control-label mt-2 mb-3">@lang('backend::user.roles.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4" data-multiple=".role-container" data-template="#new">
        <?php $old_lines = array_group(old('roles') ?? []); ?>
        {{-- add product current roles --}}
        @if (isset($resource)) @foreach($resource->roles as $idx => $selected)
            @include('backend::users.role', [
                'roles'         => $roles,
                'selected'      => $selected,
                'old'           => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach @endif

        {{-- add new added --}}
        @foreach($old_lines as $old)
            {{-- ignore empty --}}
            @if ( ($old['permission_id'] ?? null) === null)
                @continue
            @endif
            @include('backend::users.role', [
                'roles'         => $roles,
                'selected'      => null,
                'old'           => $old,
            ])
        @endforeach

        {{-- add empty for adding new roles --}}
        @include('backend::users.role', [
            'roles'         => $roles,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>

<x-backend-form-controls
    submit="backend::users.save"
    cancel="backend::users.cancel" cancel-route="backend.users" />
