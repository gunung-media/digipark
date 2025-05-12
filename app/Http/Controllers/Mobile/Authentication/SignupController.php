<?php

namespace App\Http\Controllers\Mobile\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Seeker\Seeker;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SignupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Mobile/Authentication/Signup');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:seekers,email',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            Seeker::create([
                ...$validated,
                'password' => bcrypt($request->password),
                'address' => ''
            ]);

            DB::commit();

            return redirect()->route('mobile.login')->with('success', 'Akun berhasil dibuat! Silakan login.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to store seeker', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return redirect()->route('mobile.signup')->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
        }
    }
}
