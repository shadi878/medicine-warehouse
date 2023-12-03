<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('User_Role') ;
    }
    public function GetUserData(Request $request): JsonResponse
    {
        $userData = $request->user();

        return response()->json([
            'status' => 1,
            'data' => $userData,
            'message' => 'User data',
        ]);
    }

    public function addFavorite(Request $request): JsonResponse
    {
        $user = $request->user();
        $id = intval($request->route('ID')) ;
        $medicine = Medicine::query()->find($id);

        if (!$medicine) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'invalid',
            ]);
        }

        Favorite::query()->create([
            'user_id' => $user['id'],
            'medicine_id' => $id,
        ]);

        return response()->json([
            'status' => 1,
            'data' => [],
            'message' => 'add successfully',
        ]);
    }

    public function GetFavorite(Request $request): JsonResponse
    {
        $data = [];
        $user = $request->user();
        $favorites = Favorite::query()->where('user_id', '=', $user['id'])->get();

        if (!$favorites) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'you do not have any Favorites items :)',
            ]);
        }

        $count = 0 ;
        foreach ($favorites as $favorite) {
            $medicine = Medicine::query()->find($favorite['medicine_id']);
            $data[$count] = $medicine;
            $count += 1;
        }

        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => 'all Favorites',
        ]);

    }
}

