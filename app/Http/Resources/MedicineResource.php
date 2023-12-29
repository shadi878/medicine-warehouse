<?php

namespace App\Http\Resources;

use App\Models\Favorite;
use App\Models\User;
use App\Traits\Imagefile;
use App\Traits\ReturnDataName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MedicineResource extends JsonResource
{
    use ReturnDataName , Imagefile;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {

        //check favorite medicine for user :
        $data =  parent::toArray($request);
        $user = $request->user() ;
        $favorite = Favorite::query()->where('user_id' , '=' , $user['id'])
            ->where('medicine_id' , '=', $data['id'])->first();
        if($favorite) {
            $data['favorite'] = true;
        }else{
            $data['favorite'] = false ;
        }
        $data['warehouse'] = $this->WarehouseName($data['warehouse_id']);
        $data['category'] = $this->CategoryName($data['category_id']);
        $data['image'] = $this->GetImage($data['image']);
        return $data ;
    }
}
