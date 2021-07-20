<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\CompanyDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Company as Resource;
use HDSSolutions\Laravel\Models\File;

class CompanyController extends Controller {

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
        return $dataTable->render('backend::companies.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load images
        $images = File::images()->get();
        // show create form
        return view('backend::companies.create', compact('images'));
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

        // check new uploaded image
        if ($request->hasFile('logo_id')) {
            // upload image
            $image = File::upload($request, $request->file('logo_id'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()
                    ->withErrors($image->errors())
                    ->withInput();
            // set uploaded image into resource
            $resource->logo_id = $image->id;
        }

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors($resource->errors())
                ->withInput();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.companies');
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
        // load images
        $images = File::images()->get();
        // show edit form
        return view('backend::companies.edit', compact('resource', 'images'));
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

        // check new uploaded image
        if ($request->hasFile('logo_id')) {
            // upload image
            $image = File::upload($request, $request->file('logo_id'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()
                    ->withErrors($image->errors())
                    ->withInput();
            // set uploaded image into resource
            $resource->logo_id = $image->id;
        }

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
    public function destroy($id) {
        // find resource
        $resource = Resource::findOrFail($id);
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors($resource->errors());
        // redirect to list
        return redirect()->route('backend.companies');
    }
}
