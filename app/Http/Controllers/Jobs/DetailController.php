<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $jobId)
    {
        $job = Job::with('company')->findOrFail($jobId);
        return view('portal.jobs.detail', compact('job'));
    }
}
