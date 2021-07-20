<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Region as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('regions.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('regions.crud.show');
    }

    public function create(User $user) {
        return $user->can('regions.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('regions.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('regions.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('regions.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('regions.crud.destroy');
    }
}
