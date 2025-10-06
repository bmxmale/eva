<?php

declare(strict_types=1);

namespace App\Enum\Passport;

enum Type: string
{
    case ORDINARY = 'P';
    case DIPLOMATIC = 'D';
    case SERVICE = 'S';
    case TEMPORARY = 'PP';

    public function label(): string
    {
        return match ($this) {
            self::ORDINARY => 'Ordinary Passport',
            self::DIPLOMATIC => 'Diplomatic Passport',
            self::SERVICE => 'Service Passport',
            self::TEMPORARY => 'Temporary Passport',
        };
    }
}
