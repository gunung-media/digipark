<?php

namespace App\Http\Controllers\Mobile\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SignupController extends Controller
{
    public function index()
    {
        return Inertia::render('Mobile/Authentication/Signup');
    }
}
