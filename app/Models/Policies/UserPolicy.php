<?php

namespace hDSSolutions\Laravel\Models\Policies;

use hDSSolutions\Laravel\Models\User as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('users.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('users.crud.show');
    }

    public function create(User $user) {
        return $user->can('users.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('users.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('users.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('users.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('users.crud.destroy');
    }
}
