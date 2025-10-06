<?php

declare(strict_types=1);

namespace App\Enum\Application;

enum PurposeOfVisit: int
{
    case OTHER = 0;
    case TOURISM = 1;
    case BUSINESS = 2;
    case STUDY = 3;
    case WORK = 4;
    case MEDICAL = 5;
    case TRANSIT = 6;

    public function label(): string
    {
        return match ($this) {
            self::OTHER => 'Other purpose',
            self::TOURISM => 'Tourism purpose',
            self::BUSINESS => 'Business purpose',
            self::STUDY => 'Study purpose',
            self::WORK => 'Work purpose',
            self::MEDICAL => 'Medical treatment',
            self::TRANSIT => 'Transit purpose',
        };
    }
}
