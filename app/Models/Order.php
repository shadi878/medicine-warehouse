<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'total_amount',
        'status',
        'payment_status',
        'warehouse_id',
        'user_id',
    ] ;

    public function orderItem() : HasMany {
        return $this->hasMany(OrderItem::class) ;
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class) ;
    }

}
