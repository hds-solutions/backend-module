@if ($errors->any())
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                Error
                @foreach ($errors->all() as $error)
                    <div class="small">{{ $error }}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <label class="col-3 control-label">Nombre</label>
    <div class="col-6">
        <input name="firstname" type="text"
            value="{{ isset($user) && !old('firstname') ? $user->firstname : old('firstname') }}" required
            class="form-control {{ $errors->has('firstname') ? 'is-danger' : '' }}" placeholder="Nombre">
    </div>
</div>

<div class="form-group">
    <label class="col-3 control-label">Apellido</label>
    <div class="col-6">
        <input name="lastname" type="text"
            value="{{ isset($user) && !old('lastname') ? $user->lastname : old('lastname') }}" required
            class="form-control {{ $errors->has('lastname') ? 'is-danger' : '' }}" placeholder="Apellido">
    </div>
</div>

<div class="form-group">
    <label class="col-3 control-label">Email</label>
    <div class="col-6">
        <input name="email" type="email"
            value="{{ isset($user) && !old('email') ? $user->email : old('email') }}" required
            class="form-control {{ $errors->has('email') ? 'is-danger' : '' }}" placeholder="Email">
    </div>
</div>

<div class="form-group">
    <label class="col-3 control-label">Contraseña</label>
    <div class="col-6">
        <input name="password" type="password"
            value="" {{ isset($user) ? '' : 'required' }} autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}" placeholder="Contraseña (mínimo 6 caracteres)">
    </div>
</div>

<div class="form-group">
    <label class="col-3 control-label">Confirmar Contraseña</label>
    <div class="col-6">
        <input name="password_confirmation" type="password"
            value="" {{ isset($user) ? '' : 'required' }} autocomplete="new-password"
            class="form-control {{ $errors->has('password') ? 'is-danger' : '' }}" placeholder="Contraseña (mínimo 6 caracteres)">
    </div>
</div>

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.admins') }}" class="btn btn-danger">Cancelar</a>
    </div>
</div>
