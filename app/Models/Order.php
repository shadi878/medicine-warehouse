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
        'status',
        'payment_status',
        'total_price',
        'warehouse_id',
        'user_id',
    ] ;

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function orderItem() : HasMany {
        return $this->hasMany(OrderItem::class) ;
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class) ;
    }

}
