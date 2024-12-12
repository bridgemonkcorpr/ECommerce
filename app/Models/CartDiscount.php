<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'cart_item_id',
        'discount_id',
        'code',
        'type',
        'amount',
    ];
}
