<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Inertia\Inertia;

class JobDetailController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')->latest()->get();
        return Inertia::render('Mobile/JobDetail', [
            'jobs' => $jobs
        ]);
    }
}
