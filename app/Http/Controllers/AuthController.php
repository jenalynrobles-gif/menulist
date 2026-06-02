<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

  public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'gender' => 'required|in:male,female,other',
    ]);

    try {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);

        return redirect()->route('login')
            ->with('success', 'Account created successfully! Please login.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Something went wrong!');
    }
}

    public function showLogin()
    {
        return view('login');
    }

 public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('landing')
            ->with('success', 'Welcome back!');
    }

    return back()
        ->with('error', 'Invalid credentials.')
        ->withInput();
}       public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
    public function landing()
{
    return view('landing');
}
}