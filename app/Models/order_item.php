<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class order_item extends Model
{
    use HasFactory;

    public function order() : BelongsTo
    {
        return $this->belongsTo(order::class);
    }
    public function medicine(): HasOne
    {
        return $this->hasOne(medicine::class) ;
    }
}
