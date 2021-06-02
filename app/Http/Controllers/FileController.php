<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\FileDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\File as Resource;

class FileController extends Controller {

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
        return $dataTable->render('backend::files.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // show create form
        return view('backend::files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // validate request
        $this->validate($request, Resource::$uploadRules);

        // upload file
        $resource = Resource::upload($request, $request->file('file'), $this);

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
            redirect()->route('backend.files');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $image) {
        // redirect to list
        return redirect()->route('backend.files');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $image) {
        // redirect to images
        return redirect()->route('backend.files');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $image) {
        // update object
        if (!$image->update($request->only( Resource::updateRules($image->id, true) )))
            // redirect with errors
            return back()
                ->withErrors($image->errors())
                ->withInput();

        // redirect to list
        return redirect()->route('backend.files');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $image
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
        return redirect()->route('backend.files');
    }
}
