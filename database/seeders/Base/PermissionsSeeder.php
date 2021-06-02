<?php

namespace HDSSolutions\Finpar\Seeders\Base;

use HDSSolutions\Finpar\Models\Role;
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
                'guard_name'    => config('auth.defaults.guard')
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
        $title = __(($this->namespace ? "{$this->namespace}::" : '').$resource.'.title');
        return [
            "$resource.*"           => "Full $title access",
            "$resource.crud.*"      => "All $title crud actions",
            "$resource.crud.index"  => "$title listing",
            "$resource.crud.create" => "$title creation",
            "$resource.crud.show"   => "$title detail",
            "$resource.crud.update" => "$title modification",
            "$resource.crud.destroy"=> "$title deletion",
        ];
    }

    protected final function document(string $resource):array {
        $title = __(($this->namespace ? "{$this->namespace}::" : '').$resource.'.title');
        return [
            "$resource.document.*"          => "Full $title document actions",
            "$resource.document.prepareIt"  => "$title document preparation",
            "$resource.document.approveIt"  => "$title document approving",
            "$resource.document.rejectIt"   => "$title document rejection",
            "$resource.document.completeIt" => "$title document completition",
            "$resource.document.closeIt"    => "$title document closing",
            "$resource.document.reOpenIt"   => "$title document re-opening",
        ];
    }

    protected final function role(string $name, array $permissions):void {
        // find existing role or create a new one
        $role = Role::findOrCreate($name);
        // give permissions to role
        $role->givePermissionTo( $permissions );
    }

}
