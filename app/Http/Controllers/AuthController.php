<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create([
            'Username' => $request->Username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Reģistrācija veiksmīga!',
            'user' => new UserResource($user),
        ], 201);
    }

   public function login(Request $request)
    {
        $credentials = $request->validate([
            'Username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('Username', $credentials['Username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid username or password.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
        ]);
    }
}
