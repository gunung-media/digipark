<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->except('_token');

        if (NewsComment::create($data)) {
            return redirect()->back()->with('success', 'Success Input Komentar');
        }
        return redirect()->back()->with('error', 'Error Input Komentar');
    }
}
