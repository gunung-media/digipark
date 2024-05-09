<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Admin\DepartementMember;
use App\Models\Company\Job;
use App\Models\Admin\News\News;
use App\Models\Admin\News\NewsCategory;
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
        $jobs = Job::active()->with('company')->limit('3')->latest()->get();
        $departementMembers = DepartementMember::active()->get();
        $total = [
            'pekerjaan' => Job::active()->count(),
            'perusahaan' => Company::count(),
        ];
        return view('portal.index', compact('news', 'categories', 'jobs', 'total', 'departementMembers'));
    }
}
