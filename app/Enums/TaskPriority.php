<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum TaskPriority: string
{
    use EnumToArray;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
