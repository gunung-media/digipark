<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\News;
use App\Models\Admin\News\NewsCategory;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $berita = News::with(['comments' => fn ($query) => $query->active(), 'tags'])->where('slug', $slug)->firstOrFail();
        $beritaTags = $berita->tags->pluck('id')->toArray();
        $relatedBerita = News::with(['tags' => fn ($query) => $query->whereIn('news_id', $beritaTags)])
            ->whereNot('slug', $slug)
            ->limit(2)
            ->latest()
            ->get();
        $news = News::with(['category'])->limit(4)->get();
        $categories =  NewsCategory::with('news')->get();
        return view('portal.news.detail', compact('berita', 'news', 'categories', 'relatedBerita'));
    }
}
