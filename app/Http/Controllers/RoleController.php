<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\RoleDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Role as Resource;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load permissions
        $permissions = Permission::all();

        // group permissions into a tree
        $groups = $this->permissionsTree($permissions);

        // show create form
        return view('backend::roles.create', compact('groups', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load permissions
        $permissions = Permission::all();

        // group permissions into a tree
        $groups = $this->permissionsTree($permissions);

        // show edit form
        return view('backend::roles.edit', compact('groups', 'permissions', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // find resource
        $resource = Resource::findOrFail($id);
        // root role cant be modified
        if ($resource->id === 0)
            // return back with errors
            return back()->withErrors('Root role can\'t be modified');

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // update Role permissions
        $resource->syncPermissions( $request->input('permissions') );

        // redirect to list
        return redirect()->route('backend.roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // find resource
        $resource = Resource::findOrFail($id);
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
