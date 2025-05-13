<?php

namespace App\Http\Controllers\Mobile\Service;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use App\Models\Seeker\ClaimJht;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class ClaimJhtController extends Controller
{
    public function index(): Response
    {
        $jobs = Job::with('company')->latest()->get();
        return Inertia::render('Mobile/Service/ClaimJht', [
            'jobs' => $jobs
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required',
            'signature' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $claim = new ClaimJht();
            $claim->type = $validated['type'];
            $claim->signature = $validated['signature'];
            $claim->seeker_id = auth('seeker')->id();
            $claim->save();

            DB::commit();

            return redirect()->route('mobile.service.index')->with('success', 'Klaim JHT berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Failed to store JHT claim', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('mobile.service.claim-jht')->with('error', 'Terjadi kesalahan saat menyimpan klaim jht. Silakan coba lagi.');
        }
    }
}
