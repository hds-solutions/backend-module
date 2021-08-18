<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use HDSSolutions\Laravel\Models\Base\User as BaseUser;

class User extends BaseUser {
    use HasFactory;
    use HasRoles;

    public function getFullNameAttribute():string {
        return ($this->lastname !== null ? $this->lastname.', ' : '').$this->firstname;
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

}
