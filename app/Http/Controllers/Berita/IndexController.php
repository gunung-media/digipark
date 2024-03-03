<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $name = $request->get('q');
        $news = News::with('category');
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

        return view('portal.berita.index', compact('news', 'categories', 'name', 'category'));
    }
}
