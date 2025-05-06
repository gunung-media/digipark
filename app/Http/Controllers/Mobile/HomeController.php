<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Mobile/Home');
    }
}
