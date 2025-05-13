<?php

namespace App\Http\Controllers\Mobile\Service;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Mobile/Service/Service');
    }

    public function jobApplication(): Response
    {
        return Inertia::render('Mobile/Service/JobApplication', [
            'applications' => auth('seeker')->user()->applications()
                ->with(['job.company'])
                ->latest()
                ->get(),
        ]);
    }
}
