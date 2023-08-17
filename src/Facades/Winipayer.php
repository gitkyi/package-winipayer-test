<?php

namespace Winipayer\Winipayer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Winipayer\Winipayer\Winipayer
 */
class Winipayer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Winipayer\Winipayer\Winipayer::class;
    }
}
