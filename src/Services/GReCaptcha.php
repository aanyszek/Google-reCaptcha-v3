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

    private $error = null;

    public function renderJS()
    {
        $reCaptchaSiteKey = config('g-re-captcha.site_key');

        return new HtmlString("<script src='https://www.google.com/recaptcha/api.js?render=$reCaptchaSiteKey'></script>
                <script>
                    var grecaptcha_token; 
                    function grecaptcha_reset(){
                        grecaptcha.ready(function () {
                            grecaptcha.execute('$reCaptchaSiteKey', {action: 'contact_page'}).then(function (token) {
                                grecaptcha_token = token; 
                                $('.g-site-token').val(token);
                            });
                        });
                    }
                    
                    grecaptcha_reset(); 
                </script>");
    }

    public function input()
    {
        return new HtmlString("<input class='g-site-token' type='hidden' name='g_site_token'>");
    }
}
