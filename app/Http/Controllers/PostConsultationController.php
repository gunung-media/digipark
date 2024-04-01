<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
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
            'description' => 'required',
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
            return redirect()->back()->with('success', 'Your consultation has been sent successfully.');
        }
        return redirect()->back()->with('error', 'Something went wrong.');
    }
}
