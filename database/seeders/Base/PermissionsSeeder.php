<?php

namespace HDSSolutions\Laravel\Seeders\Base;

use HDSSolutions\Laravel\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

abstract class PermissionsSeeder extends Seeder {

    public function __construct(
        private ?string $namespace = null,
    ) {}

    public final function run() {
        // bulk insert
        Permission::insert(
            // get permissions list
            $this->parse( $this->permissions() )
            // assign name and guard
            ->transform(fn($description, $permission) => [
                'name'          => is_integer($permission) ? $description : $permission,
                'description'   => is_integer($permission) ? null : $description,
                'guard_name'    => config('auth.defaults.guard'),
                'created_at'    => now(),
            ])
            // convert to array
            ->toArray()
        );

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // execute after run() process
        $this->afterRun();
    }

    private function parse(array $permissions):Collection {
        $result = collect();
        foreach ($permissions as $permission => $description) {
            if (is_array($description))
                $this->parse($description)
                    ->each(fn($ele, $idx) => $result->put($idx, $ele));
            else
                $result->put($permission, $description);
        }
        return $result;
    }

    protected abstract function permissions():array;

    protected function afterRun():void {}

    protected final function resource(string $resource):array {
        $title = ($this->namespace ? "{$this->namespace}::" : '').$resource;
        return [
            "$resource.*"           => "$title.permissions.*",
            "$resource.crud.*"      => "$title.permissions.crud.*",
            "$resource.crud.index"  => "$title.permissions.crud.index",
            "$resource.crud.create" => "$title.permissions.crud.create",
            "$resource.crud.show"   => "$title.permissions.crud.show",
            "$resource.crud.update" => "$title.permissions.crud.update",
            "$resource.crud.destroy"=> "$title.permissions.crud.destroy",
        ];
    }

    protected final function document(string $resource):array {
        $title = ($this->namespace ? "{$this->namespace}::" : '').$resource;
        return [
            "$resource.document.*"          => "$title.permissions.document.*",
            "$resource.document.prepareIt"  => "$title.permissions.document.prepareIt",
            "$resource.document.approveIt"  => "$title.permissions.document.approveIt",
            "$resource.document.rejectIt"   => "$title.permissions.document.rejectIt",
            "$resource.document.completeIt" => "$title.permissions.document.completeIt",
            "$resource.document.closeIt"    => "$title.permissions.document.closeIt",
            "$resource.document.reOpenIt"   => "$title.permissions.document.reOpenIt",
        ];
    }

    protected final function role(string $name, array $permissions):void {
        // find existing role or create a new one
        $role = Role::findOrCreate($name);
        // give permissions to role
        $role->givePermissionTo( $permissions );
    }

}
