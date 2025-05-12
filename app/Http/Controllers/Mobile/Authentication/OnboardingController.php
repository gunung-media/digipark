<?php

namespace App\Http\Controllers\Mobile\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OnboardingController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Mobile/Authentication/Onboarding');
    }
}
