<?php

namespace App\Http\Controllers\Mobile\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function detail($slug): Response
    {
        return Inertia::render('Mobile/Home/NewsDetail', [
            'news' => News::where('slug', $slug)->first()
        ]);
    }
}
