<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Seeker\Seeker;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $mode = request()->query('mode');
        return view('portal.auth.register', compact('mode'));
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
        if ((
            $mode == "company" &&  Company::create([
                ...$data,
                'password' => bcrypt($request->input('password')),
                'image' => $image
            ])
        ) || (
            $mode == 'seeker' && Seeker::create([
                ...$data,
                'password' => bcrypt($request->input('password')),
            ])
        )) {
            return redirect()->route('portal.auth.login', ['mode' => $mode])->with('status', 'Register berhasil');
        }
        return redirect()->route('portal.auth.register', ['mode' => $mode])->with('error', 'Register gagal');
    }
}
