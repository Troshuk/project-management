<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum SortDirection: string
{
    use EnumToArray;

    case DESC = 'desc';
    case ASC = 'asc';
}
