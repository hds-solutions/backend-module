<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\CompanyDataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Company as Resource;

class CompanyController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyDataTable $dataTable) {
        // load resources
        if ($request->ajax()) return $dataTable->ajax();
        // return view with dataTable
        return $dataTable->render('backend::companies.index', [ 'count' => Resource::count() ]);

        // fetch all objects
        $resources = Resource::all();
        // show a list of objects
        return view('backend::companies.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // show create form
        return view('backend::companies.create');
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
                ->withErrors($resource->errors())
                ->withInput();

        // redirect to list
        return redirect()->route('backend.companies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.companies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // show edit form
        return view('backend::companies.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource) {
        // update resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors($resource->errors())
                ->withInput();

        // redirect to list
        return redirect()->route('backend.companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource) {
        // delete object
        $resource->delete();
        // redirect to list
        return redirect()->route('backend.companies');
    }
}
