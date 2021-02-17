<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendController extends Controller {

    public function index(Request $request) {
        // redirect to dashboard
        return redirect()->route('backend.dashboard');
    }

    public function dashboard(Request $request) {
        //
        return view('backend::dashboard.index');
    }

}