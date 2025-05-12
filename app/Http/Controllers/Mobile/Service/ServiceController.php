<?php

namespace App\Http\Controllers\Mobile\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Mobile/Service/Service');
    }
}
