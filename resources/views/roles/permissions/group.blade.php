<div class="col-{{ match($level ?? 1) {
    1 => '12',
    2 => '4',
    default => '12',
} }} accordion @if (count($childs)) pb-2 @endif" id="permission-accordion-{{ $permission->id }}">
    <div class="card borderless">

        <div class="card-header p-2 {{ match($level ?? 1) {
            1 => 'bg-dark text-white',
            2 => 'bg-secondary text-white',
            default => 'bg-light',
        } }}">
            <div class="input-group">
                <div class="input-group-prepend mr-2">
                    <label class="switch">
                        <input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}"
                            value="{{ $permission->id }}"
                            @if (isset($resource) && $resource->hasPermissionTo($permission)) checked @endif
                            class="success">
                        <span class="slider"></span>
                    </label>
                </div>

                <label @if (count($childs))
                    data-toggle="collapse" data-target="#permission-collapse-{{ $permission->id }}"
                    @else
                    for="permission-{{ $permission->id }}"
                    @endif
                    class="col p-0 form-check-label text-decoration-none cursor-pointer collapsed">
                    {{ $permission->description }} <i class="state float-right"></i>
                </label>
            </div>
        </div>

        @if (count($childs))
        <div class="collapse @if ($permission->name === '*') show @endif" id="permission-collapse-{{ $permission->id }}"
            data-expanded="{{ $permission->name === '*' ? 'true' : 'false' }}"
            data-parent="#permission-accordion-{{ $permission->id }}">
            <div class="row card-body p-0 pl-4">
                @foreach ($childs as $permission_child => $permissino_childs)
                    @include('backend::roles.permissions.group', [
                        'permission'    => $permissions->firstWhere('id', $permission_child),
                        'childs'        => $permissino_childs,
                        'level'         => ($level ?? 1) + 1,
                    ])
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
