<?php

namespace App\Enums;

enum ShippingCarrier: string
{

    //UPS shipping carrier ko represent karta hai, jiska value 'ups' hai.
    case UPS = 'ups';

    // USPS shipping carrier ko represent karta hai, jiska value 'usps' hai.
    case USPS = 'usps';
    // USPS shipping carrier ko represent karta hai, jiska value 'usps' hai.
    case FEDEX = 'fedex';
    // Agar koi aur shipping carrier ho, toh usko represent karta hai, jiska value 'other' hai.
    case OTHER = 'other';
//Har shipping carrier ke liye ek human-readable label(value) return karta hai
    public function label(): string
    {
        return match ($this) {
            self::UPS => 'UPS',
            self::USPS => 'USPS',
            self::FEDEX => 'Fedex',
            self::OTHER => 'Other',
        };
    }
}
