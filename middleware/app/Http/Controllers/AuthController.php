<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            $token = JWTAuth::attempt($request->only(
                'email', 'password'
            ), [
                'exp' => Carbon::now()->addHour()->timestamp
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'auth' => [
                        'Invalid login credentials'
                    ]
                ]
            ]);
        }

        if ($token) {
            $user = $request->user();

            $user['token'] = $token;

            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'error',
            'errors' => [
                'auth' => [
                    'Invalid login credentials'
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->only(
            'first_name', 'last_name', 'email', 'password'
        );

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        if ($user) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();

        if ($token) {
            JWTAuth::invalidate($token);

            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
