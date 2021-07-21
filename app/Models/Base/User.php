<?php

namespace HDSSolutions\Laravel\Models\Base;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

use Illuminate\Notifications\Notifiable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmailContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'email_confirmation',
        'password',
        'password_confirmation',
        'type',
        'status',
        // 'avatar_id',
        // 'city_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $rules = [
        'firstname' => [ 'sometimes', 'min:2' ],
        'lastname'  => [ 'sometimes', 'nullable', 'min:2' ],
        'email'     => [ 'sometimes', 'email', 'confirmed', 'unique:users,email,{id}' ],
        'password'  => [ 'sometimes', 'string', 'confirmed', 'min:6' ],
        'type'      => [ 'sometimes' ],
        'status'    => [ 'sometimes' ],
    ];

    public final function getIsAdminAttribute() {
        return in_array($this->type, [ 'admin', 'user' ]);
    }

}
