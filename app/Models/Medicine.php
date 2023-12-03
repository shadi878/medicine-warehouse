<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable =[
        'scientific_name',
        'trade_name',
        'quantity_available',
        'price',
        'company',
        'quantity',
        'expiration_date',
        'warehouse_id',
        'category_id',
    ];

    public function warehouse() : BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }

    public function category() : BelongsTo{
        return $this->belongsTo(Category::class) ;
    }

   public function scopeFilterName(Builder $query , string $name) : Builder{
        return $query->where('name' , 'LIKE' , '%'.$name.'%') ;
   }

   public static function scopeLatestAddition(Builder $query) : Builder
   {
        return $query->orderByDesc('created_at')->offset(0)->limit(20);
   }

}
