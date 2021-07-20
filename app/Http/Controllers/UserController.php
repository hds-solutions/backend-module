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
        return $dataTable->render('backend::users.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load roles
        $roles = Role::all();

        // show create form
        return view('backend::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            return back()
                ->withErrors($resource->errors())
                ->withInput();

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load roles
        $roles = Role::all();

        // show edit form
        return view('backend::users.edit', compact('roles', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
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
        $resource->fill([ 'email_confirmation' => $resource->email ]);

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors($resource->errors())
                ->withInput();

        // check password change
        if ($request->has('password')) $resource->update([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // find resource
        $resource = Resource::findOrFail($id);

        // check current user or root account
        if (auth()->user()->id == $resource->id || $resource->id == 1) return back();

        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors($resource->errors());
        // redirect to list
        return redirect()->route('backend.users');
    }
}
