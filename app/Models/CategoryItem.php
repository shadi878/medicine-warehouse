<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
         'category_id' ,
         'medicine_id'
    ] ;

    public function category() : BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function medicine() : HasOne {
        return $this->hasOne(Medicine::class);
    }
}
