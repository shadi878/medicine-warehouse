<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function Login(Request $request) : JsonResponse{

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

        if($user['role'] == 'user'){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'sorry but you do not have access :)',
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
