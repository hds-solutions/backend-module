<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\BranchDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Branch as Resource;
use HDSSolutions\Finpar\Models\City;
use HDSSolutions\Finpar\Models\File;
use HDSSolutions\Finpar\Models\Region;

class BranchController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTable $dataTable) {
        // load resources
        if ($request->ajax()) return $dataTable->ajax();
        // return view with dataTable
        return $dataTable->render('backend::branches.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load companies
        $companies = backend()->companies();
        // load Regions
        $regions = Region::with([
            'cities',
        ])->get();
        // show create form
        return view('backend::branches.create', compact('regions', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // create resource
        $resource = new Resource;

        // set region from city
        $request->merge([ 'region_id' => City::find($request->city_id)->region_id ?? null ]);

        // fill resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors($resource->errors())
                ->withInput();

        // redirect to list
        return redirect()->route('backend.branches');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.branches');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load companies
        $companies = backend()->companies();
        // load Regions
        $regions = Region::with([
            'cities',
        ])->get();
        // show edit form
        return view('backend::branches.edit', compact('resource', 'regions', 'companies'));
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

        // fill resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors($resource->errors())
                ->withInput();

        // redirect to list
        return redirect()->route('backend.branches');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource) {
        // find resource
        $resource = Resource::findOrFail($id);
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors($resource->errors());
        // redirect to list
        return redirect()->route('backend.branches');
    }
}
