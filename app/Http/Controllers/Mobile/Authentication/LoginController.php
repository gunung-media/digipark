<?php

namespace App\Http\Controllers\Mobile\Authentication;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Mobile/Authentication/Login');
    }
}
