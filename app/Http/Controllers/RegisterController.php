<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Log::info($request->all());
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'name' => 'required|string|max:50']);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response($user, 201);
    }
    public function login(Request $request)
    {
        // Log::info($request->all());
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string']);
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 401);
        }

        $token = $user->createToken('access-token')->plainTextToken;

        // response
        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
            Auth::user()->currentAccessToken()->delete();
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return response()->json($response);
    }

}
