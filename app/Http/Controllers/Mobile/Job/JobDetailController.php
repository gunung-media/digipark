<?php

namespace App\Http\Controllers\Mobile\Job;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Inertia\Inertia;
use Inertia\Response;

class JobDetailController extends Controller
{
    public function index($id): Response
    {
        $job = Job::with('company')->find($id);
        return Inertia::render('Mobile/Job/JobDetail', [
            'job' => $job
        ]);
    }
}
