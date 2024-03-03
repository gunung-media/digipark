<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
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
        $dashboard = Dashboard::with(['images', 'visions'])->first();
        $news = News::with('category')->limit(4)->get();
        $categories =  NewsCategory::with('news')->get();
        $jobs = Job::where('status', 1)->limit('3')->get();
        return view('portal.index', compact('dashboard', 'news', 'categories', 'jobs'));
    }
}
