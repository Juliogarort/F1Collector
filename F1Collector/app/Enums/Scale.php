<?php

namespace App\Enums;

enum Scale: string
{
    case OneEighteen = '1:18';
    case OneFortyThree = '1:43';
    case OneTwelve = '1:12';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
