<?php
/**
 * Created by PhpStorm.
 * User: aanyszek
 * Date: 10.05.19
 * Time: 12:18
 */

namespace AAnyszek\GoogleReCaptcha\Services;

use Illuminate\Support\HtmlString;

class GReCaptcha
{
    public function renderJS()
    {
        $reCaptchaSiteKey = config('g-re-captcha.site_key');
        $refreshInterval  = config('g-re-captcha.refresh_interval');

        $js = "     var grecaptcha_token; 
                    function grecaptcha_reset(){
                        grecaptcha.ready(function () {
                            grecaptcha.execute('$reCaptchaSiteKey', {action: 'contact_page'}).then(function (token) {
                                grecaptcha_token = token; 
                                $('.g-site-token').val(token);
                            });
                        });
                    }
                    
                    grecaptcha_reset(); ";

        if ($refreshInterval) {
            $js .= "    setInterval(function() {
                        grecaptcha_reset(); 
                        }, $refreshInterval); ";
        }

        return new HtmlString("<script src='https://www.google.com/recaptcha/api.js?render=$reCaptchaSiteKey'></script>
                <script>
                    $js  
                </script>");
    }

    public function input()
    {
        return new HtmlString("<input class='g-site-token' type='hidden' name='g_site_token'>");
    }
}
