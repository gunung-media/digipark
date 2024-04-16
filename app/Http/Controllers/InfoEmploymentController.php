<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\Livewire;

class InfoEmploymentController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('portal.info-employment');
    }
}
