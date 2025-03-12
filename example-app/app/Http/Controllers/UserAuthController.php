<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function randomRib()
    {
        do {
            $accountNumber = str_pad(rand(0, 999999999999), 14, '0', STR_PAD_LEFT);
            $number = Wallet::where('number', $accountNumber)->exists();
        } while ($number);

        return $accountNumber;
    }
    public function register(Request $request)
    {
        $register = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);
        $user = User::create([
            'name' => $register['name'],
            'email' => $register['email'],
            'password' => Hash::make($register['password']),
            'role_id' =>1,
        ]);
        $wallet = Wallet::create([
            'number' => $this->randomRib(),
            'user_id' => $user->id,
            'balance' => 0,

        ]);
        return response()->json([
            'message' =>$user,
        ]);
    }
    public function login(Request $request)
    {

        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }
} 
