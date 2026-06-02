<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users         = User::latest()->get();
        $totalUsers    = $users->count();
        $activeUsers   = $users->where('status', 'active')->count();
        $inactiveUsers = $users->where('status', 'inactive')->count();
        $cacheTs       = time(); // ✅ single timestamp for all avatar URLs in the loop

        return view('dashboard', compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers', 'cacheTs'));
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'in:male,female'],
            'role'   => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['password'] = Hash::make('Password@123'); // default password

        User::create($validated);

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'gender' => ['required', 'in:male,female'],
            'role'   => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully!']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted successfully!']);
    }
}