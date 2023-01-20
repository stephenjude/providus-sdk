<?php

namespace Providus\Providus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Providus\Providus\Providus
 */
class Providus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Providus\Providus\Providus::class;
    }
}
