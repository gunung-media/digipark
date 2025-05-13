<?php

namespace App\Http\Controllers\Mobile\Profile;

use App\Http\Controllers\Controller;
use App\Models\Seeker\Seeker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ChangePasswordController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Mobile/Profile/ChangePassword');
    }

    public function proceed(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => 'required|min:6',
            'old_password' => 'required',
        ]);
        DB::beginTransaction();

        try {
            $user = auth('seeker')->user();
            if (!auth('seeker')->attempt(['email' => $user->email, 'password' => $validated['old_password']])) {
                return redirect()->back()->withErrors([
                    'old_password' => 'Password lama tidak cocok!',
                ]);
            }

            Seeker::find($user->id)->update([
                'password' => bcrypt($validated['password']),
            ]);
            DB::commit();
            return redirect()->route('mobile.profile.change-password.index')->with('success', 'Berhasil mengubah password!');
        } catch (\Exception $th) {
            DB::rollBack();

            return redirect()->route('mobile.profile.change-password.index')->with('error', "Terjadi kesalahan");
        }
    }
}
