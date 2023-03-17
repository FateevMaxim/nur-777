<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
     * Display the login view.
     */
    public function createAdmin(): View
    {
        return view('auth.login-admin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): View | RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        $user = User::where('login', $request->login)
            ->where('is_active', true)
            ->first();
        if ($user){
            return redirect()->route('dashboard');
        }else{
            return view('register-me');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $url = '/';
        if(Auth::user()->type !== null){
            $url = "/stock";
        }
        Auth::guard('web')->logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($url);
    }
}