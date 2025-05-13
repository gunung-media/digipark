<?php

namespace App\Http\Controllers\Mobile\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Mobile/Authentication/Login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (auth('seeker')->attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            return redirect()->route('mobile.home');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Akun tidak ditemukan!',
            ]);
        }
    }

    public function logout(): RedirectResponse
    {
        auth('seeker')->logout();

        return redirect(route('mobile.landing'));
    }
}
