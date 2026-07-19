<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle authentication.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'string', 'in:learner,instructor'],
            'locale' => ['nullable', 'string', 'in:en,yo,ha,ig'],
        ]);

        $remember = $request->filled('remember');

        // We attempt normal authentication
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Optionally check if the user's role matches their selected login role
            if ($user->role !== $credentials['role']) {
                // Ensure role matches to prevent unauthorized login attempts
                if ($credentials['role'] === 'instructor' && !in_array($user->role, ['instructor', 'admin'])) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Unauthorized: This account is not registered as an Instructor.',
                    ])->onlyInput('email');
                }
            }

            // Sync user locale with form selected locale if present
            if (!empty($credentials['locale'])) {
                $user->update(['locale' => $credentials['locale']]);
                session(['locale' => $credentials['locale']]);
                App::setLocale($credentials['locale']);
            } else {
                session(['locale' => $user->locale]);
                App::setLocale($user->locale);
            }

            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the admin login form.
     */
    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    /**
     * Handle admin authentication.
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'locale' => ['nullable', 'string', 'in:en,yo,ha,ig'],
        ]);

        $remember = $request->filled('remember');

        // Hardcoded Admin Login
        if ($credentials['email'] === 'rootedadmin@gmail.com' && $credentials['password'] === 'password123') {
            $admin = User::firstOrCreate(
                ['email' => 'rootedadmin@gmail.com'],
                [
                    'name' => 'Funmi Adesina',
                    'password' => Hash::make('password123'),
                    'role' => 'admin',
                    'locale' => 'en',
                    'culture_frame' => 'yoruba',
                ]
            );
            
            // Just to be absolutely sure role is admin if it already existed but was changed
            if ($admin->role !== 'admin') {
                $admin->update(['role' => 'admin']);
            }

            Auth::login($admin, $remember);
            $request->session()->regenerate();
            session(['locale' => $admin->locale]);
            App::setLocale($admin->locale);

            return redirect()->intended('/dashboard')->with('success', 'Welcome back, Admin!');
        }

        // We attempt normal authentication for admin role from Database
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Unauthorized: This account does not have Admin privileges.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Sync user locale with form selected locale if present
            if (!empty($credentials['locale'])) {
                $user->update(['locale' => $credentials['locale']]);
                session(['locale' => $credentials['locale']]);
                App::setLocale($credentials['locale']);
            } else {
                session(['locale' => $user->locale]);
                App::setLocale($user->locale);
            }

            return redirect()->intended('/dashboard')->with('success', 'Welcome back, Admin!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:learner,instructor'],
            'culture_frame' => ['required', 'string', 'in:yoruba,hausa,igbo,panafrican,universal'],
            'locale' => ['required', 'string', 'in:en,yo,ha,ig'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'locale' => $request->locale,
            'culture_frame' => $request->culture_frame,
        ]);

        if ($user->role === 'instructor') {
            // No dummy courses created on registration per user request
        }

        Auth::login($user);

        // Store locale preference in session
        session(['locale' => $user->locale]);
        App::setLocale($user->locale);

        return redirect('/dashboard')->with('success', 'Registration successful. Welcome to RootED!');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/users/login')->with('success', 'Logged out successfully.');
    }
}
