<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('expo-app')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'account_type' => $user->account_type,
                'role' => [
                    User::ADMIN => 'admin',
                    User::STUDENT => 'student',
                    User::FACULTY => 'faculty',
                ][$user->account_type] ?? null,
                'name' => $user->getName(),
                'profile' => $user->getUser(),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
