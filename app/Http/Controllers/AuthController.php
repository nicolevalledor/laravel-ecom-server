<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        $data = User::where('usertype','user')->get();

        return response([
            'data' => $data,
            'message' => "View all the Records"
        ],200);
    }

    public function register(Request $request ){
        $fields = $request->validate([
            'username'=>'required|string|unique:users,username',
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
        ]);

        $user = User::create([
            'username'=>$fields['username'],
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
            'phone' => $fields['phone'],
            'address' => $fields['address'],
        ]);

        $token = $user->createToken('test')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token
        ]);
    }

    public function login(Request $request ){
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response(['message'=>'Invalid credentials'],401);
        }

        $token = $user->createToken('test')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token
        ]);
    }


    public function logout() {
        auth()->user()->tokens()->delete();

        return response([
            'message'=>"Logged out successfully",
        ], 201);
    }

    public function authUser() {
        return response([
            'user' => Auth::user(),
            'message'=>"Auth User Logged in",
        ], 200);
    }

}
