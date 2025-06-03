<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Check email
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad credentials',
            ], 401);
        }

        // Check if user is active
        if ($user->status != 1) {
            return response()->json([
                'message' => 'Your account is inactive. Please contact an administrator.',
            ], 403);
        }

        // Create token
        $tokenResult = $user->createToken('auth_token');

        // Return response with roles
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user->load('roles'),
            'token' => $tokenResult->plainTextToken,
        ], 200);
    }

    public function register(Request $request)
    {
        // register
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1, // Active status
            'is_admin' => 0, // Not an admin
        ]);

        // Check if guest role exists, create it if not
        $guestRole = Role::firstOrCreate(['name' => 'guest']);

        // Assign guest role to user
        $user->assignRole($guestRole);

        // Create token
        // $token = $user->createToken('auth_token')->plainTextToken;

        // Return response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->load('roles'),
            // 'token' => $token,
        ], 201);
    }
}
