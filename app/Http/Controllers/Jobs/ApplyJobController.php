<?php

namespace App\Http\Controllers\Jobs;

use App\Filament\Company\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Seeker\JobApplicant;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class ApplyJobController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!auth('seeker')->check())
            return redirect()->route('portal.login', ['mode' => 'seeker'])->with('error', 'Anda perlu login!');

        if (JobApplicant::where('job_id', $request->job_id)->where('seeker_id', auth('seeker')->user()->id)->first())
            return redirect()->back()->with('error', 'Anda Sudah Mengapply Pekerjaan');

        $data = ['job_id' => $request->input('job_id'), 'seeker_id' => auth('seeker')->user()->id];
        if (JobApplicant::create($data)) {
            Notification::make()
                ->title('There is a new applicant')
                ->body('There is a new applicant' . auth('seeker')->user()->name)
                ->info()
                ->actions([
                    Action::make('View')->url(JobResource::getUrl('edit', ['record' => $request->job_id], true, 'company'))->button(),
                ])
                ->sendToDatabase(Company::whereHas('jobs', function ($query) use ($request) {
                    $query->where('id', $request->job_id);
                })->first());
            return redirect()->back()->with('success', 'Success Apply Pekerjaan, Silahkan tunggu');
        }
        return redirect()->back()->with('error', 'Terjadi Kesalahan Saat Mengapply Pekerjaan, Silahkan Coba Lagi');
    }
}
