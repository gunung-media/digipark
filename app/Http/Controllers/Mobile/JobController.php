<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class JobController extends Controller
{
    public function index()
    {
        return Inertia::render('Mobile/Job');
    }
}
