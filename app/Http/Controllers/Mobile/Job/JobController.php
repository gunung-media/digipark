<?php

namespace App\Http\Controllers\Mobile\Job;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    public function index(): Response
    {
        $jobs = Job::with('company')->latest()->active()->get();
        return Inertia::render('Mobile/Job/Job', [
            'jobs' => $jobs
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        $jobs = Job::query()
            ->with('company')
            ->when(
                $search,
                fn($q) =>
                $q->where('name_job', 'like', "%{$search}%")
                    ->orWhereRelation('company', 'name', 'like', "%{$search}%")
            )
            ->limit(10)
            ->get();

        return response()->json(['jobs' => $jobs]);
    }
}
