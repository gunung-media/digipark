<?php

namespace App\Http\Controllers\Mobile\Job;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Inertia\Inertia;
use Inertia\Response;

class JobDetailController extends Controller
{
    public function index(): Response
    {
        $jobs = Job::with('company')->latest()->get();
        return Inertia::render('Mobile/Job/JobDetail', [
            'jobs' => $jobs
        ]);
    }
}
