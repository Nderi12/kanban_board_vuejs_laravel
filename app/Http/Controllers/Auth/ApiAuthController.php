<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    /**
     * Function handling registration
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    /**
     * Function handling login
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function login(Request $request)
    {
        if (auth()->attempt($request->all())) {
            return response([
                'user' => auth()->user(),
                'access_token' => auth()->user()->createToken('authToken')->accessToken
            ], Response::HTTP_OK);
        }


        return response([
            'message' => 'This User does not exist'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Function handling logout
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
