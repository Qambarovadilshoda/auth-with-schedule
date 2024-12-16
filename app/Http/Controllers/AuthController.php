<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->verification_token = uniqid();
        $user->save();

        return $this->success($user, 'User created successfully', 201);
    }
    public function login(LoginRequest $request){

    }
    public function getUser(Request $request){

    }
    public function logout(Request $request){

    }
}
