<?php

namespace Reallyli\Uninotify\Facades;

use Illuminate\Support\Facades\Facade;

class UniNotify extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uninotify';
    }
}