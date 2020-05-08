<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $loginDetails = $request->only('email', 'password');

        if (! Auth::guard('web')->attempt($loginDetails)) {
            return response()->json(['message' => 'Invalid credentials', 'code' => 422], 422);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $user = User::where('id', auth()->id())->with('roles')->first();

        $role = $user->roles->first();

        return response()->json(
        [
            'message' => 'login successful',
            'accessToken' => $accessToken,
            'user' => $user,
            'role' => $role->name,
            'code' => 200
        ]);
    }

    public function authProfile()
    {
        $auth = Employee::where('id', auth()->id())
            ->with('user')
            ->first();

        $result = [
            'message' => 'successfully retrieved authenticated user',
            'auth' => $auth
        ];

        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    }
}
