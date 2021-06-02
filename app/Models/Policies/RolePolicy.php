<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Role as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('roles.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('roles.crud.show');
    }

    public function create(User $user) {
        return $user->can('roles.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('roles.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('roles.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('roles.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('roles.crud.destroy');
    }
}
