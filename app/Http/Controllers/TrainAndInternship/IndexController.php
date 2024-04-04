<?php

namespace App\Http\Controllers\TrainAndInternship;

use App\Http\Controllers\Controller;
use App\Models\Admin\TrainAndInternship;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request): View|Factory
    {
        $name = $request->get('q');
        $datas = TrainAndInternship::active();

        if (!is_null($name)) {
            $datas->where('name', 'like', '%' . $name . '%');
        }

        $datas = $datas->get();

        return view('portal.train-and-internship.index', compact('datas', 'name'));
    }
}
