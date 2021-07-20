<?php

namespace HDSSolutions\Laravel\Seeders;

use HDSSolutions\Laravel\Models\Role;

class BackendPermissionsSeeder extends Base\PermissionsSeeder {

    public function __construct() {
        parent::__construct('backend');
    }

    protected function permissions():array {
        return [
            '*' => 'Full platform access',
            $this->resource('roles'),
            $this->resource('users'),
            $this->resource('regions'),
            $this->resource('cities'),
            $this->resource('companies'),
            $this->resource('branches'),
            $this->resource('files'),
        ];
    }

    protected function afterRun():void {
        // create Root role
        $role = Role::create([ 'name' => 'Root' ]);
        // force to has 0 as id
        $role->forceFill([ 'id' => 0 ])->save();

        // give full access to Root
        $role->givePermissionTo('*');
    }

}
