<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use App\Role;

class AuthController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login() {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $credential['token'] =  $user->createToken('LaravelPassport')->accessToken;
            return response()->json([
              'credential' => $credential,
              'user' => $user
            ], 200);
        }
        else{
            return response()->json(['errors'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 401);
        }

        $roleId = Role::where('role', 'USER')->get()->first()->id;

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = $roleId;

        $user = User::create($input);
        $credential['token'] =  $user->createToken('LaravelPassport')->accessToken;

        return response()->json([
          'credential'=>$credential,
          'user'=>$user
        ], 200);
    }
}
