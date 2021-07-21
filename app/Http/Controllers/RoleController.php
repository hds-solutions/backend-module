<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\RoleDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Role as Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    public function index(Request $request, DataTable $dataTable) {
        // check only-form flag
        if ($request->has('only-form'))
            // redirect to popup callback
            return view('backend::components.popup-callback', [ 'resource' => new Resource ]);

        // load resources
        if ($request->ajax()) return $dataTable->ajax();

        // return view with dataTable
        return $dataTable->render('backend::roles.index', [ 'count' => Resource::count() ]);
    }

    public function create(Request $request) {
        // load permissions
        $permissions = Permission::all();

        // group permissions into a tree
        $groups = $this->permissionsTree($permissions);

        // show create form
        return view('backend::roles.create', compact('groups', 'permissions'));
    }

    public function store(Request $request) {
        // start a transaction
        DB::beginTransaction();

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // update Role permissions
        $resource->syncPermissions( $request->input('permissions') );

        // commit changes to database
        DB::commit();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.roles');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.roles');
    }

    public function edit(Request $request, Resource $resource) {
        // load permissions
        $permissions = Permission::all();

        // group permissions into a tree
        $groups = $this->permissionsTree($permissions);

        // show edit form
        return view('backend::roles.edit', compact('groups', 'permissions', 'resource'));
    }

    public function update(Request $request, Resource $resource) {
        // root role cant be modified
        if ($resource->id === 0)
            // return back with errors
            return back()->withErrors('Root role can\'t be modified');

        // start a transaction
        DB::beginTransaction();

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // update Role permissions
        $resource->syncPermissions( $request->input('permissions') );

        // commit changes to database
        DB::commit();

        // redirect to list
        return redirect()->route('backend.roles');
    }

    public function destroy(Request $request, Resource $resource) {
        // reject if role is root
        if ($resource->id === 0)
            // return back with error message
            return back()->withErrors('Root role can\'t be removed');

        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()->withErrors($resource->errors());

        // redirect to list
        return redirect()->route('backend.roles');
    }

    private function permissionsTree(Collection $permissions):array {
        // get permission id as array key
        $groups = array_fill_keys($permissions->pluck('id')->toArray(), [ 'parents' => [], 'childs' => [] ]);

        // foreach permissions that ends with *
        foreach ($permissions->filter(fn($permission) => str_ends_with($permission->name, '*')) as $group)
            // foreach permissions that starts with permission above
            foreach ($permissions->filter(fn($find) => $find->id !== $group->id && str_starts_with($find->name, rtrim($group->name, '*'))) as $found) {
                // register * permission on found permission
                $groups[$found->id]['parents'][] = $group->id;
            }

        // return permissions tree
        return $this->cleanTree( $this->buildTree($groups) );
    }

    private function buildTree(array $groups):array {
        $tree = [];
        // move each group to first parent found
        foreach ($groups as $idx => $group) {
            // check if group has parent
            if (count($group['parents']) === 0) {
                $tree[$idx] = $group;
                continue;
            }
            // move group to parent
            $parent = array_shift($group['parents']);
            $tree[$parent]['childs'][$idx] = $group;
        }
        // build the tree for each grouped child
        foreach ($tree as $idx => $childs)
            $tree[$idx]['childs'] = $this->buildTree($childs['childs']);
        // return builded tree
        return $tree;
    }

    private function cleanTree(array $groups):array {
        $tree = [];
        // save group ID as array key
        foreach ($groups as $idx => $group)
            $tree[$idx] = $this->cleanTree($group['childs']);
        // return cleaned tree
        return $tree;
    }

}
