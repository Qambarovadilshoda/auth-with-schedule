<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
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

        SendEmailJob::dispatch($user);

        return $this->success(new UserResource($user), 'User created successfully', 201);
    }
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->firstOrFail();
        if($user->email_verified_at == null){
            return $this->error('Email not verified', 403);
        }
        if(!Hash::check($request->password, $user->password)){
            return $this->error('Password is incorrect');
        }
        
    }
    public function getUser(Request $request){

    }
    public function logout(Request $request){

    }
    public function emailVerify(Request $request){
        $user = User::where('verification_token', $request->token)->firstOrFail();
        $user->email_verified_at = now();
        $user->save();

        return $this->success([], 'Email verified successfully');

    }
}
