<?php

namespace App\Http\Controllers\Mobile\Service;

use App\Http\Controllers\Controller;
use App\Models\Seeker\ClaimJht;
use Inertia\Inertia;
use Inertia\Response;

class TrackClaimJhtController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Mobile/Service/TrackClaimJht', [
            'claims' => ClaimJht::with('tracks')
                ->where('seeker_id', auth('seeker')->id())
                ->get(),
        ]);
    }

    public function show($id): Response
    {
        $claim = ClaimJht::with('tracks')
            ->where('seeker_id', auth('seeker')->id())
            ->findOrFail($id);

        return Inertia::render('Mobile/Service/TrackClaimJhtDetail', [
            'claim' => $claim,
            'tracks' => $claim->tracks()->orderBy('created_at')->get(),
        ]);
    }
}
