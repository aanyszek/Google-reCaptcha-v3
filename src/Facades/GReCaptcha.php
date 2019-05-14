<?php
/**
 * Created by PhpStorm.
 * User: aanyszek
 * Date: 10.05.19
 * Time: 12:03
 */

namespace AAnyszek\GoogleReCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class GReCaptcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GReCaptcha';
    }
}