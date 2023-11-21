<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    use HasFactory;

    protected $fillable =[
      'scientific_name',
        'trade_name',
        'price',
        'company',
        'quantity',
        'expiration_date',
    ];


}
