<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\CityDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Region;
use HDSSolutions\Laravel\Models\City as Resource;

class CityController extends Controller {

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

        // load regions
        $regions = Region::ordered()->get();

        // return view with dataTable
        return $dataTable->render('backend::cities.index', compact('regions') + [ 'count' => Resource::count() ]);
    }

    public function create(Request $request) {
        // load regions
        $regions = Region::ordered()->get();

        // show create form
        return view('backend::cities.create', compact('regions'));
    }

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
            redirect()->route('backend.cities');
    }

    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.cities');
    }

    public function edit(Resource $resource) {
        // load regions
        $regions = Region::ordered()->get();

        // show edit form
        return view('backend::cities.edit', compact('resource', 'regions'));
    }

    public function update(Request $request, Resource $resource) {
        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.cities');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors($resource->errors());

        // redirect to list
        return redirect()->route('backend.cities');
    }

}
