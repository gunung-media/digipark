<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $mode = request()->query('mode');
        return view('portal.register', compact('mode'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'mode']);
        $mode = $request->input('mode');
        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $image = storage_path('app/public/company') . '/' . $fileName;
            $file->move(storage_path('app/public/company'), $fileName);
        }
        if ($mode == "perusahaan" && Company::create([
            ...$data,
            'password' => bcrypt($request->input('password')),
            'image' => $image
        ])) {
            return redirect()->route('portal.login')->with('status', 'Register berhasil');
        }
        return redirect()->route('portal.register', ['mode' => $mode])->with('error', 'Fitur belum tersedia');
    }
}
