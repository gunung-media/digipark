<?php

namespace App\Http\Controllers\Consultation;

use App\Filament\Admin\Resources\ConsultationResource;
use App\Filament\Admin\Resources\NewsResource;
use App\Http\Controllers\Controller;
use App\Models\Admin\Consultation;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostConsultationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->except('_token');
        $validate = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'file' => 'mimes:pdf,jpg,png,jpeg,docx,max:2048',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first());
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('consultations', 'public');
        }

        if (Consultation::create($data)) {
            Notification::make()->title('Ada Konsultasi Baru')
                ->body('Ada Konsultasi baru oleh ' . $request->name)
                ->info()
                ->actions([
                    Action::make('View')->url(ConsultationResource::getUrl('index', ['tableSearch' => $request->name]))
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase(User::all());
            return redirect()->back()->with('success', 'Your consultation has been sent successfully.');
        }
        return redirect()->back()->with('error', 'Something went wrong.');
    }
}
