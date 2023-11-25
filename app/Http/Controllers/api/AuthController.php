<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ResponseController;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ResponseController
{
    public function login(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('usertoken')->accessToken;
            return $this->_sendResponse("Login successfully.",$token);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('usertoken')->accessToken;
        return $this->_sendResponse("Register successfully.",$token);
    }
    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->json(['message' => 'Logout successfully'], 200);
    }
}
