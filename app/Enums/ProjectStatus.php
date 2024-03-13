<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ProjectStatus: string
{
    use EnumToArray;

    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
