<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\FileDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\File as Resource;

class FileController extends Controller {

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
        return $dataTable->render('backend::files.index', [ 'count' => Resource::count() ]);
    }

    public function create(Request $request) {
        // show create form
        return view('backend::files.create');
    }

    public function store(Request $request) {
        // validate request
        $this->validate($request, Resource::$uploadRules);

        // upload file
        $resource = Resource::upload($request, $request->file('file'), $this);

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.files');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.files');
    }

    public function edit(Request $request, Resource $resource) {
        // redirect to images
        return redirect()->route('backend.files');
    }

    public function update(Request $request, Resource $resource) {
        // fill resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.files');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.files');
    }
}
