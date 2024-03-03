<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $berita = News::where('slug', $slug)->firstOrFail();
        $news = News::with('category')->limit(4)->get();
        $categories =  NewsCategory::with('news')->get();
        return view('portal.berita.detail', compact('berita', 'news', 'categories'));
    }
}
