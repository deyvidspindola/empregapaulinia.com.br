<?php

namespace App\Http\Enum;

enum JobTypes: string
{
    case CLT = 'CLT';
    case PJ = 'PJ';
    case FREELANCER = 'Freelancer';
    case ESTAGIO = 'Estágio';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_combine(self::values(), self::values());
    }
}