<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class category_item extends Model
{
    use HasFactory;

    public function category() : BelongsTo
    {
        return $this->belongsTo(category::class);
    }
    public function medicine(): HasOne
    {
        return $this->hasOne(medicine::class) ;
    }
}
