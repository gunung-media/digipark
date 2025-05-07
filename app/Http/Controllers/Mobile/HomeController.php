<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\News;
use App\Models\Company\Job;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $job = Job::with('company')->latest()->first();
        $news = News::with('category')->latest()->take(5)->get();
        return Inertia::render('Mobile/Home', [
            'job' => $job,
            'news' => $news
        ]);
    }
}
