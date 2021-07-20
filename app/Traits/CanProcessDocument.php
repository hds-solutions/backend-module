<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Interfaces\Document;
use HDSSolutions\Laravel\Processes\DocumentEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait CanProcessDocument {

    protected function redirectTo():string {
        // fallback to dashboard
        return 'backend.dashboard';
    }

    protected abstract function documentClass():string;

    public final function processIt(Request $request, $resource) {
        // get action
        $action = $request->input('action') ?? null;

        // find resource
        $resource = $this->documentClass()::findOrFail($resource);

        // check if resource is instance of Document
        if (!$resource instanceof Document)
            // return with errors
            return back()
                ->withInput()
                ->withErrors([ 'Invalid request' ]);

        // build permission
        $permission =
            // model name in lower and separated by _
            Str::snake(Str::pluralStudly( class_basename($resource) ))
            // document permission container
            .'.document.'.
            // document action
            ($action_str = strtolower(str_replace('ACTION_', '', DocumentEngine::__($action, 'action', false))).'It');

        // check if user has permission
        if (!$request->user()->can($permission))
            // return back with error
            return back()->withErrors( "backend::document.$action_str.unauthorized" );

        // start a transaction
        DB::beginTransaction();

        // execute document action
        if (!$resource->processIt( $action ))
            // redirect back with errors
            return back()->withErrors( $resource->getDocumentError() );

        // confirm transaction
        DB::commit();

        // redirect to document
        return redirect()->route( $this->redirectTo(), $resource );
    }
}
