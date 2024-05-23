<?php

namespace App\Infusio\Facade;

use Illuminate\Support\Facades\Facade;

class Infusio extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'infusio';
    }
}
