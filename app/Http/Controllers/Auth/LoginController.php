<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $mode = request()->query('mode');
        return view('portal.auth.login', compact('mode'));
    }

    public function login(Request $request, $mode)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth($mode)->attempt($credentials)) {
            return redirect(route($mode === "seeker" ? 'portal.jobs.index' : 'portal'));
        }
        return redirect()->back()->with('error', 'Login failed, please try again');
    }

    public function logout()
    {
        auth('company')->logout();
        auth('seeker')->logout();
        return redirect(route('portal.login'));
    }
}
