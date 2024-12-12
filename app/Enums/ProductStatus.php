<?php

namespace App\Enums;

enum ProductStatus
{
    //Product abhi draft state mein hai, matlab final version nahi hai.
    case DRAFT;
    //Product active hai, matlab available hai ya sale ke liye ready hai.
    case ACTIVE;
    //Product archived ho chuka hai, matlab inactive ya purana ho gaya hai.
    case ARCHIVED;

    //Har status ke liye ek label return karta hai
//Is method mein trans() function use kiya gaya hai jo multi-language support ke liye hota hai, matlab yeh labels translations ke liye ready hain
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => trans('Draft'),
            self::ACTIVE => trans('Active'),
            self::ARCHIVED => trans('Archived'),
        };
    }
}
