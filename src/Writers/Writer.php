<?php

namespace SKprods\Telegram\Writers;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getDriverFromConfig()
 *
 * @see WriterManager
 */
class Writer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'chatInfoWriter';
    }
}