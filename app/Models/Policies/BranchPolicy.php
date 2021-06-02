<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Branch as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('branches.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('branches.crud.show');
    }

    public function create(User $user) {
        return $user->can('branches.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('branches.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('branches.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('branches.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('branches.crud.destroy');
    }
}
