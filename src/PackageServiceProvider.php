<?php
/**
 * Created by PhpStorm.
 * User: aanyszek
 * Date: 10.04.19
 * Time: 15:12
 */

namespace AAnyszek\GoogleReCaptcha;

use AAnyszek\GoogleReCaptcha\Services\GReCaptcha;

class PackageServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GReCaptcha', function () {
            return new GReCaptcha();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/g-re-captcha.php', 'g-re-captcha');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'g-re-captcha');

        $this->publishFiles();
    }

    public function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/config/g-re-captcha.php' => config_path('g-re-captcha.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/lang/en/captcha.php' => resource_path('lang/vendor/g-re-captcha/en/captcha.php')
        ], 'lang');
    }
}