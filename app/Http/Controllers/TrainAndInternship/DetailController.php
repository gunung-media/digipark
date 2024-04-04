<?php

namespace App\Http\Controllers\TrainAndInternship;

use App\Http\Controllers\Controller;
use App\Models\Admin\TrainAndInternship;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $slug)
    {
        $data = TrainAndInternship::where('slug', $slug)->firstOrFail();
        return view('portal.train-and-internship.detail', compact('data'));
    }
}
