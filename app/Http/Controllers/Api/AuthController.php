<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                'mobile_no' => 'required|string',
                'fcm_token' => 'required|string'
            ]);
    
            // Create a new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'mobile_no' => $validatedData['mobile_no']
            ]);
    
            // Check if the user was created successfully
            if ($user) {
                $user->assignRole('Patient'); // Or use Role::findById(3)->name if needed

                return response()->json([
                    'status' => true,
                    'message' => 'User registered successfully',
                    'user_details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'mobile_no' => $user->mobile_no,
                        'fcm_token' => $validatedData['fcm_token'],
                        'role' => '3'
                    ]
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status'=>true,'access_token' => $token, 'token_type' => 'Bearer','user_details'=>[
            'name' => $user->name,
            'email' => $user->email,
            'mobile_no'=>$user->mobile_no,
            'fcm_token'=>'',
            'role'=>$user->roles->pluck('id')[0],
            'user_id'=>$user->id,
            'token' => $token
        ]]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
