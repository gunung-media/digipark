<?php

namespace App\Http\Controllers\Mobile\Service;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Inertia\Inertia;
use Inertia\Response;

class ClaimJhtController extends Controller
{
    public function index(): Response
    {
        $jobs = Job::with('company')->latest()->get();
        return Inertia::render('Mobile/Service/ClaimJht', [
            'jobs' => $jobs
        ]);
    }
}
