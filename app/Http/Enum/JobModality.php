<?php

namespace App\Http\Enum;

enum JobModality: string
{
    case PRESENCIAL = 'Presencial';
    case REMOTO = 'Remoto';
    case HIBRIDO = 'Híbrido';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_combine(self::values(), self::values());
    }
}
