<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'identifier',
        'description',
        'instructions',
        'is_enabled',
        'is_primary',
        'is_third_party',
        'meta',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_primary' => 'boolean',
        'is_third_party' => 'boolean',
        'meta' => 'array',
    ];
}
