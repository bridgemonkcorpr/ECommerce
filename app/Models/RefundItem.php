<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'quantity',
        'is_shipped',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'is_shipped' => 'boolean',
    ];
}
