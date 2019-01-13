<?php

namespace CreditInfo;

use Illuminate\Support\ServiceProvider;

class CreditInfoServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/credit-info.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('credit-info.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'credit-info'
        );

        $this->app->bind('credit-info', function () {
            return new CreditInfo();
        });

        $this->app->singleton(WsClient::class, function () {
            $wsdl = config('credit-info.wsdl_url');
            $soap_options = [
                'login' => config('credit-info.username'),
                'password' => config('credit-info.password'),
                'exceptions' => true,
                'trace' => 1,
                'connection_timeout' => 1,
            ];

            if (config('credit-info.cache_wsdl') === false) {
                $soap_options['cache_wsdl'] = WSDL_CACHE_NONE;
            }

            return new WsClient($wsdl, $soap_options);
        });
    }
}
