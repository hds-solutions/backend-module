<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\City as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('cities.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('cities.crud.show');
    }

    public function create(User $user) {
        return $user->can('cities.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('cities.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('cities.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('cities.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('cities.crud.destroy');
    }
}
