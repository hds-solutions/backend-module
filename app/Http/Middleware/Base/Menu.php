<?php

namespace HDSSolutions\Finpar\Http\Middleware\Base;

use HDSSolutions\Finpar\Models\User;

abstract class Menu {

    public function __construct(
        private ?User $user,
    ) {
        $this->user = auth()->user();
    }

    protected final function user():User {
        return $this->user;
    }

    protected final function can(string $permission):bool {
        return $this->user?->can($permission) ?? false;
    }

}
