@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="backend::role.name.0"
    placeholder="backend::role.name._"
    {{-- helper="backend::role.name.?" --}} />

<x-form-row>
    <x-form-label text="backend::role.permissions.0" form-label class="align-top" />

    <div class="col">
        <div class="row">
            @foreach ($groups as $permission => $childs)
                @include('backend::roles.permissions.group', [
                    'permission'    => $permissions->firstWhere('id', $permission),
                    'childs'        => $childs,
                ])
            @endforeach
        </div>
    </div>
</x-form-row>

<x-backend-form-controls
    submit="backend::roles.save"
    cancel="backend::roles.cancel" cancel-route="backend.roles" />
