<?php

namespace App\Enums;

enum ShippingStatus: string
{
    //Jab order abhi tak ship nahi hua hai.
    case UNSHIPPED = 'unshipped';
    //Jab order ka kuch part ship ho chuka ho, lekin baki ka baaki ho.
    case PARTIALLY_SHIPPED = 'partially_shipped';
    //Jab order poori tarah se ship ho gaya ho.
    case SHIPPED = 'shipped';

    //Har status ke liye ek label return karta hai, jo user ko dikhaya jaata hai
    public function label(): string
    {
        return match ($this) {
            self::UNSHIPPED => __('Unshipped'),
            self::PARTIALLY_SHIPPED => __('Partially shipped'),
            self::SHIPPED => __('Shipped'),
        };
    }

    //Har status ke liye ek color code return karta hai
    public function color(): string
    {
        return match ($this) {
            self::UNSHIPPED, self::PARTIALLY_SHIPPED => '#fbbf24', // amber-400
            self::SHIPPED => '#60a5fa', // blue-400
        };
    }
}
