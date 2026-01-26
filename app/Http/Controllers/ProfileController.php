<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(Request $request)
    {
        if (auth()->user()->account_type == 1) {
            $user = Admin::find(auth()->user()->user_id);

            $validator = Validator($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $user->update([
                'name' => $request->name,
            ]);

            return back()->with('success', 'Admin information successfully updated');
        } elseif (auth()->user()->account_type == 2) {
            $user = Student::find(auth()->user()->user_id);

            $validator = Validator($request->all(), [
                'name' => 'required',
                'department' => 'required',
                'year_level' => 'required|numeric',
                'section' => 'required',
                'contact_number' => 'required|numeric',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user->update([
                'name' => $request->name,
                'department' => $request->department,
                'year_level' => $request->year_level,
                'section' => $request->section,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
            ]);

            return back()->with('success', 'Student information successfully updated');
        } elseif (auth()->user()->account_type == 3) {
            $user = Faculty::find(auth()->user()->user_id);

            $validator = Validator($request->all(), [
                'name' => 'required',
                'department' => 'required',
                'position' => 'required',
                'contact_number' => 'required|numeric',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user->update([
                'name' => $request->name,
                'department' => $request->department,
                'position' => $request->position,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
            ]);

            return back()->with('success', 'Faculty information successfully updated');
        }
    }

    public function showPassword()
    {
        return view('users.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $currentpass = Hash::check($request->current_password, auth()->user()->password);

        if ($currentpass) {
            auth()->user()->update([
                'password' => Hash::make($request->new_password),
            ]);

            return back()->with('success', 'Password updated');
        }

        return back()->withErrors('error', 'Password not match');
    }
}
