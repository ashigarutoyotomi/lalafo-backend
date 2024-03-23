<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function linkPhoneNumberViaSms(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Check if the user already has a phone number
        if ($user->phone_number) {
            // If the user already has a phone number, use it for verification
            $phoneNumber = $user->phone_number;
        } else {
            // If the user doesn't have a phone number, retrieve it from the request
            $phoneNumber = $request->input('phone_number');
            // Update the user's phone number in the database
            $user->phone_number = $phoneNumber;
            $user->save();
        }
        $verification = new PhoneVerification(['phone_number', $phoneNumber]);
        $verification->save();
        // Generate a random verification code (you can adjust the length as needed)
        $verificationCode = mt_rand(10000, 99999);

        // Store the verification code in the database or session
        // You can save it in the users table or create a separate table for verification codes
        $user->verification_code = $verificationCode;
        $user->save();

        // Simulate sending the verification code via SMS (not implemented in this example)

        // Return a response indicating that the verification code has been sent
        return response()->json(['message' => 'Verification code sent']);
    }
    public function verifyPhoneNumber(Request $request, $userId)
    {
        // Retrieve the user from the database
        $user = User::findOrFail($userId);

        // Retrieve the verification code entered by the user
        $enteredCode = $request->input('verification_code');

        // Retrieve the verification code associated with the user's phone number
        $storedCode = $this->getVerificationCode($user->phone_number);

        // Check if the stored code exists and matches the entered code
        if ($storedCode && $storedCode == $enteredCode) {
            // If the codes match, mark the phone number as verified
            $user->phone_number_verified_at = now(); // Assuming you have a "phone_number_verified_at" column in your users table
            $user->save();

            // Return a response indicating successful verification
            return response()->json(['message' => 'Phone number verified successfully']);
        } else {
            // If the codes do not match or the stored code does not exist, return an error response
            return response()->json(['error' => 'Invalid verification code'], 400);
        }
    }
    public function getVerificationCode($phoneNumber)
    {
        // Retrieve the latest verification code associated with the phone number
        $verification = PhoneVerification::where('phone_number', $phoneNumber)
            ->latest()
            ->first();
        try {
            DB::beginTransaction();
            $verification->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return $verification ? $verification->code : null;
    }
}
