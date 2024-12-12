<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'company_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postcode',
        'phone',
        'phone_country',
        'is_billing',
        'is_default',
    ];

    protected $casts = [
        'phone' => E164PhoneNumberCast::class . ':phone_country',
        'is_billing' => 'bool',
        'is_default' => 'bool',
    ];

    protected $with = [
        'country',
    ];

    public function addressable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
