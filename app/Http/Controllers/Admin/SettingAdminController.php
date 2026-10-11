<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingAdminController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'profile_image_file']);

        // Handle profile image upload
        if ($request->hasFile('profile_image_file')) {
            $request->validate([
                'profile_image_file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
            ]);

            $file = $request->file('profile_image_file');
            $filename = 'profile_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);

            Setting::set('profile_image', 'uploads/profile/' . $filename, 'hero');
        }

        foreach ($data as $key => $val) {
            Setting::set($key, $val);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Admin profile and credentials updated.');
    }
}
