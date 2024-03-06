<?php

namespace App\Http\Controllers\Pekerjaan;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $jobId)
    {
        $job = Job::with('company')->findOrFail($jobId);
        return view('portal.pekerjaan.detail', compact('job'));
    }
}
