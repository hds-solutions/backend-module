<?php

namespace HDSSolutions\Finpar\Seeders;

use HDSSolutions\Finpar\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // get a random password
        $password = Str::random(16);

        // create user
        if (!($resource = User::create([
            'firstname'         => 'Administrator',
            'email'             => $email = 'root@project.com.py',
            // 'email_confirmation'=> $email,
            // 'email_verified_at' => now(),
            'password'          => $passwd = Hash::make($password),
            // 'password_confirmation' => $passwd,
            // 'type'              => 'admin',
            // 'status'            => 'active',
        ]))) {
            // show error message
            $this->command->error($resource->errors());
            // exit execution
            return;
        }

        // create root role and assign root role to administrator
        $resource->assignRole( Role::create([ 'name' => 'root' ]) );

        // output root account data
        $this->command->info('Created root@project.com.py account with password: '.$password);
    }
}
