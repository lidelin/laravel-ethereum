<?php

namespace LDL\Ethereum;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Web3;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../config/ethereum.php'), 'ethereum');

        $this->publishes([
            realpath(__DIR__ . '/../config/ethereum.php') => config_path('ethereum.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('web3', function () {
            $host = config('ethereum.host');
            $port = config('ethereum.port');
            $timeout = config('ethereum.rpc_timeout');

            return new Web3(new HttpProvider(new HttpRequestManager("{$host}:{$port}", $timeout)));
        });
    }
}
