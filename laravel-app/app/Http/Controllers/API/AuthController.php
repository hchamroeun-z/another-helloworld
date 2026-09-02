<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SigninRequest;
use App\Http\Requests\User\SignupRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    function signup(SignupRequest $request){

    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
    ]);
    return response([
        'message'=>'user created successfully',
        'user'=>new UserResource($user)
    ],201);
    }

    function signin(SigninRequest $request){
        $user=User::where('email',$request->email)->first();
        if(!Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages(['password'=>'password does not match.']);
        }
        $token=$user->createToken('auth_token')->plainTextToken;
        return response([
            'message'=>'User log in',
            'user' => new UserResource($user),
            'token' => $token
        ],200);
    }
    function signout(Request $request){
        $user=$request->user();
        $user->currentAccessToken()->delete();

        return response([
            'message'=>'User log out'
        ],200);
    }
    function verify(Request $request){
                return response([
            'message' => 'Token is valid.',
            'user' => new UserResource($request->user()) 
        ], 200);

    }
}
