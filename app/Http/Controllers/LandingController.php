<?php

namespace App\Http\Controllers;

use App\Filament\Company\Pages\EditProfile;
use App\Filament\Seeker\Resources\ClaimJhtResource;
use App\Models\Seeker\ClaimJht;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Landing/index');
    }
}
