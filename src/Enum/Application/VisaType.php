<?php

declare(strict_types=1);

namespace App\Enum\Application;

enum VisaType: string
{
    case TRANSIT = 'A';
    case SHORT_STAY = 'C';
    case LONG_STAY = 'D';

    public function label(): string
    {
        return match ($this) {
            self::TRANSIT => 'Transit Visa',
            self::SHORT_STAY => 'Short-stay Visa',
            self::LONG_STAY => 'Long-stay Visa',
        };
    }
}
