<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // display login
    public function index(): View
    {
        return view('auth.login');
    }

    // login submit
    public function login_store(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], true)) {
            if (Auth::User()->role_id == 1) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin_dashboard'));
            } else if (Auth::User()->role_id == 2) {
                $request->session()->regenerate();
                return redirect()->intended(route('vendor_dashboard'));
            } else if (Auth::User()->role_id == 3) {
                $request->session()->regenerate();
                return redirect()->intended(route('guest_dashboard'));
            } else {
                return redirect()->back()->withErrors([
                    'login' => 'These credentials do not match our records.',
                ]);
            }
        } else {
            return redirect()->back()->withErrors([
                'login' => 'These credentials do not match our records.',
            ]);
        }
    }

    // display register
    public function register(): View
    {
        $roles = Role::all();
        return view('auth.register-halodoc', compact('roles'));
    }

    // register submit
    public function register_store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => 'required|min:8',
            'role_id' => 'required'
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        event(new Registered($user));
        return redirect()->intended(route('register'))->with('message', 'User added successfully!');
    }

    // logout
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
