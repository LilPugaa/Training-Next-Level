<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'],
            'token' => ['nullable'],
        ]);

        // Login
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Cek role sesuai pilihan
        if ($user->role->name !== $request->role) {
            Auth::logout();

            return back()->withErrors([
                'role' => 'Role yang dipilih tidak sesuai dengan akun ini.',
            ]);
        }

        // Token untuk non participant
        if($user->role->name !== 'participant') {
            if ($request->token !== $user->role->access_token) {
                Auth::logout();

                return back()->withErrors([
                    'token' => 'Token akses tidak valid.',
                ]);
            }
        }

        return match ($user->role->name) {
            'admin' => redirect()->route('admin.dashboard'),
            'coordinator' => redirect()->route('coordinator.dashboard'),
            'trainer' => redirect()->route('trainer.dashboard'),
            'branch_pic' => redirect()->route('branch_pic.dashboard'),
            'participant' => redirect()->route('participant.dashboard'),
        };

        // return redirect()->intended(route('master-dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
