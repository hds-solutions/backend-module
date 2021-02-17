<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use HDSSolutions\Finpar\Models\User;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // fetch all objects
        $resources = User::all();
        // show a list of objects
        return view('backend::users.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // show create form
        return view('backend::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // create resource
        $resource = new User( $request->input() );

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
            'password'              => $hashed = Hash::make($resource->password),
            // bypass confirmation validation
            'password_confirmation' => $hashed,
        ]);

        // redirect to list
        return redirect()->route('admin.users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(User $resource) {
        // redirect to list
        return redirect()->route('admin.users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(User $resource) {
        // show edit form
        return view('backend::users.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $resource) {
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
            'password'              => $hashed = Hash::make($resource->password),
            // bypass confirmation validation
            'password_confirmation' => $hashed,
        ]);

        // redirect to list
        return redirect()->route('admin.users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $resource) {
        // check current user or root account
        if (auth()->user()->id == $resource->id || $resource->id == 1) return back();
        // delete object
        $resource->delete();
        // redirect to list
        return redirect()->route('admin.users');
    }
}
