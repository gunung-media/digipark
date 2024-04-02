<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\News;
use App\Models\Admin\News\NewsCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $name = $request->get('q');
        $news = News::active()->with('category');
        $category = $request->get('category');

        if (!is_null($name)) {
            $news->where('title', 'like', '%' . $name . '%');
        }

        if (!is_null($category)) {
            $categoryId = NewsCategory::where('name', $category)->first()->id;
            $news->where('category_id', $categoryId);
        }

        $news = $news->get();
        $categories =  NewsCategory::with('news')->get();

        return view('portal.news.index', compact('news', 'categories', 'name', 'category'));
    }
}
