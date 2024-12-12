<?php

namespace App\Enums;

enum OrderStatus
{
    //There will be draft case when user has added the product to wishlist or trying to add the product in wishlish or the order is not processed or payment is not being made
    //Jab user ne product wishlist mein add kiya hai, ya add karne ki koshish kar raha hai, ya order process nahi hua hai, ya payment complete nahi hui hai, to usko draft case maana jayega.
    case DRAFT;

    // payment has been made and the order is processing
    //Payment ho chuki hai aur order process ho raha hai.
    case OPEN;

    // order completed and archived
    //Order complete ho chuka hai aur archive kar diya gaya hai.
    case ARCHIVED;

    // order has been cancelled
    //Order cancel kar diya gaya hai.
    case CANCELLED;

    //Har status ke liye ek color code return karta hai
    public function color(): string
    {
        return match ($this) {
            self::DRAFT => '#fbbf24', // amber-400
            self::OPEN => '#60a5fa', // blue-400
            self::ARCHIVED, self::CANCELLED => '#94a3b8', // slate-400
        };
    }

    //Har status ke liye ek label return karta hai

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::OPEN => __('Open'),
            self::ARCHIVED => __('Archived'),
            self::CANCELLED => __('Cancelled'),
        };
    }
}
