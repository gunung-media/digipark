<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use App\Models\Job;
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
        if (Job::create([...$data, "image" => $image])) {
            return redirect()->back()->with('success', 'Success Input Pekerjaan');
        }
        return redirect()->back()->with('error', 'Error input pekerjaan');
    }
}
