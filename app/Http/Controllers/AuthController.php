<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $attribute=$request->validate([
            'name'=>'required|string:255',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|string|min:8|confirmed'
        ]);
        $user=User::create([
            'name'=>$attribute['name'],
            'email'=>$attribute['email'],
            'password'=>Hash::make($attribute['password'])
        ]);
    
        //generate the token
        $token=$user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'=>true,
            'user'=>new AuthorResource($user),
            'token'=>$token
        ]);
        }


        public function login(Request $request){
            $request->validate(
                [
                    'email'=>'required|email',
                    'password'=>'required',
                ]
            );
            //get the user with email
            $user =User::where('email',$request->email)->first();

            if(!$user ||!Hash::check($request->password,$user->password)){
                return response()->json([
                    'message'=>'Incorrect password/email',
                ]);
            }
            $token=$user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message'=>'Login Successfully!',
                'user'=>new UserResource($user),
                'token'=>$token,
            ]);
        }

        public function logout(Request $request){
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success'=>true,
                'messages'=>'Logged Out!'
            ]);
        }
    
}
