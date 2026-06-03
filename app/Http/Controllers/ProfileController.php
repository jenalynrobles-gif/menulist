<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio'     => 'nullable|string|max:500',
        ]);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->bio     = $request->bio;

        if ($request->filled('current_password') || $request->filled('new_password')) {

            $request->validate([
                'current_password' => 'required',
                'new_password'     => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors([
                        'current_password' => 'Current password is incorrect.'
                    ])
                    ->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        if (!$request->hasFile('avatar')) {
            return redirect()->route('profile.edit')
                ->with('error', 'No file was uploaded.');
        }

        try {
            // Delete the old avatar from persistent storage if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the new file under uploads/ on the public disk.
            // store() returns a path relative to the disk root, e.g. "uploads/abc123.jpg"
            $path = $request->file('avatar')->store('uploads', 'public');

            if (!$path) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Failed to save the uploaded file. Please try again.');
            }

            $user->avatar = $path;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')
                ->with('error', 'An error occurred while uploading your photo: ' . $e->getMessage());
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile photo updated successfully!');
    }

    public function removePhoto()
    {
        $user = Auth::user();

        try {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        } catch (\Exception $e) {
            // Log but don't block the removal — the DB record should still be cleared
            \Log::warning('Could not delete avatar file: ' . $e->getMessage());
        }

        $user->avatar = null;
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile photo removed successfully!');
    }
}