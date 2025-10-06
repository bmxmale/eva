<?php

declare(strict_types=1);

namespace App\Enum\Passport;

/**
 * Enum representing passport codes for different countries.
 * Ref: ISO 3166-1 alpha-3 codes.
 */
enum Code: string
{
    case AUSTRALIA = 'AUS';
    case BELARUS = 'BLR';
    case CANADA = 'CAN';
    case CHINA = 'CHN';
    case CZECHIA = 'CZE';
    case FRANCE = 'FRA';
    case GERMANY = 'DEU';
    case ITALY = 'ITA';
    case JAPAN = 'JPN';
    case LITHUANIA = 'LTU';
    case POLAND = 'POL';
    case RUSSIA = 'RUS';
    case SLOVAKIA = 'SVK';
    case SPAIN = 'ESP';
    case UKRAINE = 'UKR';
    case UNITED_KINGDOM = 'GBR';
    case UNITED_STATES = 'USA';

    public function label(): string
    {
        return match ($this) {
            self::AUSTRALIA => 'Australia',
            self::BELARUS => 'Belarus',
            self::CANADA => 'Canada',
            self::CHINA => 'China',
            self::CZECHIA => 'Czechia',
            self::FRANCE => 'France',
            self::GERMANY => 'Germany',
            self::ITALY => 'Italy',
            self::JAPAN => 'Japan',
            self::LITHUANIA => 'Lithuania',
            self::POLAND => 'Poland',
            self::RUSSIA => 'Russia',
            self::SLOVAKIA => 'Slovakia',
            self::SPAIN => 'Spain',
            self::UKRAINE => 'Ukraine',
            self::UNITED_KINGDOM => 'United Kingdom',
            self::UNITED_STATES => 'United States',
        };
    }
}
