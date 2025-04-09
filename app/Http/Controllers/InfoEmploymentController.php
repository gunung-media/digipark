<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Livewire;

class InfoEmploymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $carbonMonth = Carbon::createFromFormat('Y-m', $month);
        return view('portal.info-employment', ['month' => $carbonMonth]);
    }
}
