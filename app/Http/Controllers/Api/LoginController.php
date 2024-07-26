<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Login',
            ], 401);
        }
        $user = user::where('email', $request->email)->firstOrfail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'data' => $user,
            'acces_token' => $token,
            'message' => 'login success',
        ], 200);

    }

public function register(request $request)
{
    $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }
    $user = User::create([
        'name' => $request->name,
        'email' => $request->rmsil,
        'password' => Hash::make($request->password),
    ]);
    return response()->json([
        'data'=> $user,
        'success' => true,
        'message' => 'user berhasil dibuat'
    ]);
}
}