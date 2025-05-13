<?php

namespace App\Http\Controllers\Mobile\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\News;
use App\Models\Company\Job;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $job = Job::with('company')->latest()->first();
        $news = News::with('category')->latest()->get();
        return Inertia::render('Mobile/Home/Home', [
            'job' => $job,
            'news' => $news
        ]);
    }
}
