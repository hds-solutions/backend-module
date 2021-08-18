<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\UserDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\User as Resource;
use HDSSolutions\Laravel\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

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
        return $dataTable->render('backend::users.index', [ 'count' => Resource::count() ]);
    }

    public function create(Request $request) {
        // load roles
        $roles = Role::all();

        // show create form
        return view('backend::users.create', compact('roles'));
    }

    public function store(Request $request) {
        // start a transaction
        DB::beginTransaction();

        // create resource
        $resource = new Resource( $request->input() );

        // bypass email confirmation
        $resource->fill([ 'email_confirmation' => $resource->email ]);

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // hash password
        $resource->update([
            'password'              => $hashed = bcrypt($resource->password),
            // bypass confirmation validation
            'password_confirmation' => $hashed,
        ]);

        // sync user roles
        $resource->syncRoles( collect( $request->input('roles') )
            // filter empty roles
            ->filter(fn($role) => $role !== null)
            // get Role instance
            ->transform(fn($role) => Role::findOrFail($role)) );

        // commit changes to database
        DB::commit();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.users');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.users');
    }

    public function edit(Request $request, Resource $resource) {
        // load roles
        $roles = Role::all();

        // show edit form
        return view('backend::users.edit', compact('roles', 'resource'));
    }

    public function update(Request $request, Resource $resource) {
        // start a transaction
        DB::beginTransaction();

        // check for password change
        if ($request->has('password') && $request->input('password') == null)
            // remove password attribute from request to prevent null assignment
            $request->remove([ 'password', 'password_confirmation' ]);

        // update resource with request data
        $resource->fill( $request->input() );

        // bypass email confirmation
        $resource->fill([
            'email_confirmation'    => $resource->email,
            'password_confirmation' => $resource->password,
        ]);

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // check password change
        if ($request->has('password')) $resource->update([
            // bypass email confirmation
            'email_confirmation'    => $resource->email,
            // hash password
            'password'              => $hashed = bcrypt($resource->password),
            // bypass confirmation validation
            'password_confirmation' => $hashed,
        ]);

        // sync user roles
        $resource->syncRoles( collect( $request->input('roles') )
            // filter empty roles
            ->filter(fn($role) => $role !== null)
            // get Role instance
            ->transform(fn($role) => Role::findOrFail($role)) );

        // commit changes to database
        DB::commit();

        // redirect to list
        return redirect()->route('backend.users');
    }

    public function destroy(Request $request, Resource $resource) {
        // check current user or root account
        if (auth()->user()->id == $resource->id || $resource->id == 1) return back();

        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.users');
    }
}
