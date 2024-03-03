<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('company')->attempt($credentials)) {
            return redirect(route('portal'));
        }
        return redirect()->back()->with('error', 'Login failed, please try again');
    }

    public function logout()
    {
        auth('company')->logout();
        return redirect(route('portal.login'));
    }
}
