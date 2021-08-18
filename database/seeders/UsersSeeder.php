<?php

namespace HDSSolutions\Laravel\Seeders;

use HDSSolutions\Laravel\Models\User;
use HDSSolutions\Laravel\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class UsersSeeder extends Seeder {

    public function run() {
        // get a random password
        $password = Str::random(16);

        // create user
        if (!($resource = User::create([
            'firstname'             => 'Administrator',
            'email'                 => $email = 'root@project.com.py',
            'email_confirmation'    => $email,
            'password'              => $passwd = bcrypt($password),
            'password_confirmation' => $passwd,
        ]))->exists) {
            // show error message
            $this->command->error( $resource->errors() );
            // exit execution
            return;
        }

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // assign root role to administrator
        $resource->assignRole( Role::find(0) );

        // output root account data
        $this->command->info("Created $email account with password: $password");
    }
}
