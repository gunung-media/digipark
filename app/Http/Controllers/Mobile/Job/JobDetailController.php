<?php

namespace App\Http\Controllers\Mobile\Job;

use App\Http\Controllers\Controller;
use App\Models\Company\Job;
use App\Models\Seeker\JobApplicant;
use App\Utils\FilamentUtil;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class JobDetailController extends Controller
{
    public function index($id): Response
    {
        $job = Job::with('company')->find($id);
        return Inertia::render('Mobile/Job/JobDetail', [
            'job' => $job
        ]);
    }

    public function apply($id): RedirectResponse
    {
        if (JobApplicant::where('job_id', $id)->where('seeker_id', auth('seeker')->user()->id)->first())
            return redirect()->back()->with('error', 'Anda Sudah Mengapply Pekerjaan');

        $data = ['job_id' => $id, 'seeker_id' => auth('seeker')->user()->id];
        if (JobApplicant::create($data)) {
            FilamentUtil::seekerApply(jobId: $id, sendEmail: true);
            return redirect()->route('mobile.job.detail', ['id' => $id])->with('success', 'Success Apply Pekerjaan, Silahkan tunggu');
        }
        return redirect()->route('mobile.job.detail', ['id' => $id])->with('error', 'Terjadi Kesalahan Saat Mengapply Pekerjaan, Silahkan Coba Lagi');
    }
}
