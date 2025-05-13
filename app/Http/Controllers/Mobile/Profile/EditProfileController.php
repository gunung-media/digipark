<?php

namespace App\Http\Controllers\Mobile\Profile;

use App\Http\Controllers\Controller;
use App\Models\Seeker\Seeker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class EditProfileController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Mobile/Profile/EditProfile', ['user' => auth('seeker')->user()]);
    }

    public function proceed(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:seekers,email,' . auth('seeker')->user()->id,
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
        ]);
        DB::beginTransaction();

        try {
            Seeker::find(auth('seeker')->user()->id)->update($validated);
            DB::commit();
            return redirect()->route('mobile.profile.index')->with('success', 'Berhasil mengedit akun!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('mobile.profile.edit')->with('error', 'Terjadi kesalahan saat mengedit akun. Silakan coba lagi.');
        }
    }
}
