<?php

namespace App\Http\Controllers;

use App\User;
use App\Doodle;
use Illuminate\Http\Request;
use App\Http\Requests\UserDetailRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user['id'] = $request->user()->id;
        $user['first_name'] = $request->user()->first_name;
        $user['last_name'] = $request->user()->last_name;
        $user['email'] = $request->user()->email;

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function details(UserDetailRequest $request)
    {
        $user = User::where('id', $request->user()->id);

        if ($user->count() > 0) {
            $input['first_name'] = $request->get('first_name');
            $input['last_name'] = $request->get('last_name');

            if ($request->has('password')) {
                if ($request->get('password') != null) {
                    $input['password'] = bcrypt($request->get('password'));
                }
            }

            $user = $user->update($input);

            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'user' => User::find($request->user()->id)
                ]);
            }
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    public function doodles($user_id)
    {
        $user = User::where('id', $user_id)
            ->with('doodles')
            ->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }
    }
}
