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

    public function environment(Request $request) {
        foreach ([
            'company_id'    => 'setCompany',
            'branch_id'     => 'setBranch',
            'warehouse_id'  => 'setWarehouse',
            'cash_book_id'  => 'setCashBook',
            'currency_id'   => 'setCurrency',
        ] as $field => $method)
            // set value to backend environment
            backend()->$method( $request->input( $field ) !== 'null' ? $request->input( $field ) : null );

        // return to original location
        return redirect()->back();
    }

}
