<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Dashboard;
use App\Models\DepartementMember;
use App\Models\Job;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $news = News::active()->with('category')->limit(4)->get();
        $categories =  NewsCategory::with('news')->get();
        $jobs = Job::active()->with('company')->where('status', 1)->limit('3')->latest()->get();
        $departementMember = DepartementMember::active()->first();
        $total = [
            'pekerjaan' => Job::active()->count(),
            'perusahaan' => Company::count(),
        ];
        return view('portal.index', compact('news', 'categories', 'jobs', 'total', 'departementMember'));
    }
}
