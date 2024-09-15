<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = User::create([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);

            return response()->json([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email
                ]
            ], Response::HTTP_CREATED);
        } catch (\Exception $err) {
            return response()->json(['errors' => 'failed to create user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $credentials = $request->only('username', 'password');

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'invalid username or password.'], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'accessToken' => $token,
                'refreshToken' => auth()->refresh()
            ], Response::HTTP_CREATED);
        } catch (\Exception $err) {
            return response()->json(['errors' => 'failed to login'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $newToken = auth()->setToken($request->input('token'))->refresh();

        return response()->json([
            'accessToken' => $newToken,
            'refreshToken' => $newToken,
        ], Response::HTTP_OK);
    }
}
