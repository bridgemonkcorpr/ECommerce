<?php

namespace App\Enums;

enum PaymentStatus
{
    //Payment authorize ho gaya hai, lekin poora process nahi hua.
    case AUTHORIZED;

    //Payment ka authorization ya link expire ho gaya hai.
    case EXPIRED;

    //Payment due hai, lekin abhi tak complete nahi hua.
    case OVERDUE;

    //Payment poori tarah se complete ho chuka hai.
    case PAID;

    //Payment ho gaya hai, lekin confirmation ka wait ho raha hai (webhook ya manual approval ke through).
    case PENDING;
    //Payment ka kuch part refund kiya gaya hai.
    case PARTIALLY_REFUNDED;
    //Poora payment refund ho chuka hai.
    case REFUNDED;
    //Order create hua hai, lekin payment nahi kiya gaya.
    case UNPAID;


// har case ke liye color define kiya gaya hain ki agar aisa kux aaye toh kya color show ho
    public function color(): string
    {
        return match ($this) {
            self::PENDING, self::UNPAID, self::OVERDUE => '#fbbf24', // amber-400
            self::PARTIALLY_REFUNDED, self::REFUNDED, self::EXPIRED => '#94a3b8', // slate-400
            self::AUTHORIZED, self::PAID => '#60a5fa', // blue-400
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::AUTHORIZED => __('Authorized'),
            self::EXPIRED => __('Expired'),
            self::OVERDUE => __('Overdue'),
            self::PAID => __('Paid'),
            self::PENDING => __('Awaiting Confirmation'),
            self::PARTIALLY_REFUNDED => __('Partially Refunded'),
            self::REFUNDED => __('Refunded'),
            self::UNPAID => __('Unpaid'),
        };
    }
}
