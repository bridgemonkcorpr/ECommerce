<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxZoneRate extends Model
{
    use HasFactory;

    protected $fillable = ['priority', 'percentage'];

    protected $casts = [
        'priority' => 'integer',
        'percentage' => 'float',
    ];

    public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaxZone::class, 'tax_zone_id');
    }
}
