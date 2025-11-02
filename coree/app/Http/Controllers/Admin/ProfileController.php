<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $info = Auth::guard('admin')->user();
        return view('admin.profile', compact('info'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'old_password' => [
                'required_with:new_password',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('admin')->user()->password)) {
                        $fail('The old password is incorrect.');
                    }
                },
            ],
            'new_password' => 'nullable|confirmed|min:8',
        ]);

        $admin = Auth::guard('admin')->user();

        $admin->name = $request->input('full_name');
        $admin->email = $request->input('email');

        if ($request->filled('new_password')) {
            $admin->password = Hash::make($request->input('new_password'));
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }


}
