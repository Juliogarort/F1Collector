<?php

namespace App\Enums;

enum Team: string
{
    case Ferrari = 'Ferrari';
    case RedBull = 'Red Bull';
    case Mercedes = 'Mercedes';
    case McLaren = 'McLaren';
    case Alpine = 'Alpine';
    case AstonMartin = 'Aston Martin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
