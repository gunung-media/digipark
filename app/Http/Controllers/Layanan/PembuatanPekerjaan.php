<?php

namespace App\Http\Controllers\Layanan;

use App\Filament\Resources\CompanyResource;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class PembuatanPekerjaan extends Controller
{
    public function index()
    {
        return view('portal.layanan.pembuatan-pekerjaan');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $image = storage_path('app/public/jobs') . '/' . $fileName;
            $file->move(storage_path('app/public/jobs'), $fileName);
        }
        if (Job::create([...$data, "image" => $image, 'status' => 0])) {
            Notification::make()
                ->title('There is a new job')
                ->body('There is a new job from ' . auth('company')->user()->name)
                ->info()
                ->actions([
                    Action::make('View')->url(CompanyResource::getUrl('edit', ['record' => $request->company_id]))->button(),
                ])
                ->sendToDatabase(User::all());
            return redirect()->back()->with('success', 'Success Input Pekerjaan');
        }
        return redirect()->back()->with('error', 'Error input pekerjaan');
    }
}
