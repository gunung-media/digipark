<?php

namespace App\Http\Controllers\Pekerjaan;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $name = $request->query('q');
        $jobs = Job::active();

        if (!is_null($name)) {
            $jobs = $jobs->where('name_job', 'like', '%' . $name . '%');
        }

        $jobs = $jobs->get();
        return view('portal.pekerjaan.index', compact('jobs', 'name'));
    }
}
