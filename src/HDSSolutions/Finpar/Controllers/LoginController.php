<?php

namespace HDSSolutions\Finpar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
    use AuthenticatesUsers;

    public function __construct() {
        // register middleware
        $this->middleware('guest:'.config('backend.guard'))
            // ignore logout route
            ->except('backend.logout');
    }

    protected function redirectTo() {
        // return to last position
        if (session('redirected.from', null) !== null) {
            $url = session('redirected.from');
            session()->forget('redirected.from');
            return redirect()->to($url);
        }

        // fallback, redirect to backend home
        return route('backend');
    }

    protected function guard() {
        // return configured guard for backend
        return auth()->guard( config('backend.guard') );
    }

    protected function loggedOut(Request $request) {
        // redirect to backend home
        return redirect()->route('backend');
    }

    public function showLoginForm() {
        // override default login view
        return view('backend::auth.login');
    }

}
