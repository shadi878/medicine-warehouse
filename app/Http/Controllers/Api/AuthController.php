<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request) : JsonResponse{

        $request->validate([
           'name' => 'required|min:3',
           'phone_number' => 'required|min:10|unique:users',
           'email' => 'required|email',
           'password' => 'required|min:6',
           'pharmacy_name' => 'required|unique:users',
           'image' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $imageName = '' ;
        //$imageName = time() . '.' . $request['image']->extension();
        //$request['image']->storeAs('images', $imageName);

        $user =  User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make( $request['password']),
            'phone_number' => $request['phone_number'],
            'pharmacy_name' => $request['pharmacy_name'],
            'image' => $imageName ,
        ]);

        $token = $user->createToken("Auth Token")->plainTextToken ;

        $data = [
            'user' => $user ,
            'token' => $token ,
        ] ;

        return response()->json([
            'status' => 1,
            'data' => $data ,
            'message' => 'welcome ,your account has been registered' ,
        ]) ;
    }

    public function login(Request $request) : JsonResponse{

        $request->validate([
           'phone_number' => 'required|exists:users,phone_number' ,
           'password' => 'required' ,
        ]);

        $user = User::query()->where('phone_number' , '=' , $request['phone_number'])->first();

        if(!$user || !Hash::check($request['password'] , $user['password'])){
            return response()->json([
               'status' => 0 ,
               'data' => [] ,
               'message' => 'the phone number or password is incorrect'
            ] , 422);
        }

        if($user['role'] == 'admin'){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'welcome sir but you can not login from your mobile please log in from your PC :)',
            ]);
        }

        $token = $user->createToken("Auth Token")->plainTextToken ;

        $data =[
            'user' => $user ,
            'token' => $token ,
        ];

        return response()->json([
           'status' => 1 ,
           'data' => $data ,
           'message' => 'welcome, logged in successfully',
        ]);
    }

    public function Logout() : JsonResponse{

        Auth::user()->currentAccessToken()->delete() ;
        return response()->json([
             'status' => 1 ,
             'data' => [] ,
             'message' => 'logged out successfully' ,
        ]);

    }
}
