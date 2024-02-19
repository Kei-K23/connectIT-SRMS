<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => __('auth.failed')]);
        }

        $isAuthUser = Hash::check($request->password, $user->password);

        if ($isAuthUser) {
            $request->authenticate();

            $request->session()->regenerate();

            if ($user->administrator) {
                return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
            } elseif ($user->student) {
                return redirect()->intended(RouteServiceProvider::STUDENT_HOME);
            }
        } else {
            return redirect()->back()->withErrors(['password' => __('auth.failed')]);
        }
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
