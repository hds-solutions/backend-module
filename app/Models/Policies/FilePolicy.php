<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\File as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('files.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('files.crud.show');
    }

    public function create(User $user) {
        return $user->can('files.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('files.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('files.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('files.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('files.crud.destroy');
    }
}
