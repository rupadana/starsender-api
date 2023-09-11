<?php

namespace Rupadana\StarsenderApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rupadana\StarsenderApi\StarsenderApi
 */
class StarsenderApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rupadana\StarsenderApi\StarsenderApi::class;
    }
}
