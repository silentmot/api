<?php

namespace Afaqy\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Tracer extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'tracer';
    }
}
