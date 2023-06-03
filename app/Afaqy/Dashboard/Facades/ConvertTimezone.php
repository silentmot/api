<?php

namespace Afaqy\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

class ConvertTimezone extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'convert_db_col_timezone';
    }
}
