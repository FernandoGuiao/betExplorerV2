<?php

namespace App\Providers;

use App\Overwrites\Authorised as OverwrittenAuthorised;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Protoqol\Prequel\Http\Middleware\Authorised;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias(Authorised::class, OverwrittenAuthorised::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') != 'local') {
            \URL::forceScheme('https');
        }
    }
}
