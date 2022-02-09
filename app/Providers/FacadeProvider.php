<?php

namespace App\Providers;

use App\Libs\Treasury\Client;
use Illuminate\Support\ServiceProvider;

class FacadeProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('treasury', function() { return new Client(config('trasury')); });
    }
}
