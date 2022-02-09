<?php

namespace App\Libs\Facades;

use App\Libs\Treasury\Client;
use Illuminate\Support\Facades\Facade;

/**
 * @see Client
 * @method static array|null getOfacSdn()
 */
class Treasury extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'treasury';
    }
}
