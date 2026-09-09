<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = strtolower(str_replace(' ', '_', Auth::user()->role ?? ''));

            // បង្វែរទិសដៅទៅតាម Role នីមួយៗពេល Login ជោគជ័យ
            if ($role === 'cashier') {
                return redirect()->route('loans.index'); // Cashier ទៅបញ្ជីកម្ចីសងប្រាក់
            } elseif ($role === 'loan_officer') {
                return redirect()->route('loans.pending'); // Loan Officer ទៅកម្ចីរង់ចាំអនុម័ត
            } elseif ($role === 'customer') {
                return redirect()->route('loans.my'); // Customer ទៅកម្ចីផ្ទាល់ខ្លួន
            }

            // Admin
            return redirect()->route('loans.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'customer', // កំណត់ Role ដំបូងជា customer
        ]);

        Auth::login($user);

        return redirect()->route('loans.my');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}