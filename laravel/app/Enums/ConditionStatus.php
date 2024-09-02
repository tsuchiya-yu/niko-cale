<?php

namespace App\Enums;

enum ConditionStatus: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case NORMAL = 'normal';
    case POOR = 'poor';
    case TERRIBLE = 'terrible';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
