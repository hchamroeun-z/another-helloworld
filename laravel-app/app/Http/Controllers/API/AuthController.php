<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    function signup(Request $request){
    $request->validate([
        'name'=>'required|string|max:100',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|string|min:6|max:10|confirmed'
    ]);
    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
    ]);
    return response([
        'message'=>'user created successfully',
        'user'=>$user
    ],201);
    }

    function signin(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|string|min:6|max:6'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!Hash::check($request->password,$user->password)){
            throw ValidationException::withMessage(['password'=>'password does not match.']);
        }
        $token=$user->createToken('auth_token')->plainTextToken;
        return response([
            'message'=>'User log in',
            'user' => $user,
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
            'user' => $request->user()
        ], 200);

    }
}
