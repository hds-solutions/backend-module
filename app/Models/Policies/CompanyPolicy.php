<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Company as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('companies.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('companies.crud.show');
    }

    public function create(User $user) {
        return $user->can('companies.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('companies.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('companies.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('companies.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('companies.crud.destroy');
    }
}
