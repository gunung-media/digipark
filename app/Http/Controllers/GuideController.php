<?php

namespace App\Http\Controllers;

use App\Models\Admin\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function __invoke(Request $request)
    {
        $name = $request->get('q');
        $datas = Guide::active();

        if (!is_null($name)) {
            $datas->where('name', 'like', '%' . $name . '%');
        }

        $datas = $datas->get();
        return view('portal.guide', compact('datas', 'name'));
    }
}
