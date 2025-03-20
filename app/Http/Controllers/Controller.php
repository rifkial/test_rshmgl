<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60), // Generate API token
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['user' => $user], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function getUser(Request $request)
    {
        $user = User::where('api_token', $request->header('Authorization'))->first();

        if ($user) {
            return response()->json(['user' => $user], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}