# Description 
Google ReCaptcha v3 form laravel form.  
 
 
# Installation 

Install via composer
```
composer require aanyszek/google-re-captcha
```

Add to config/app.php
```
'GReCaptcha' => AAnyszek\GoogleReCaptcha\Facades\GReCaptcha::class,
```
Add in .env file
```
GOOGLE_RE_CAPTCHA_SITE_KEY=""
GOOGLE_RE_CAPTCHA_PRV_KEY=""
```

# Usage
Paste in js section
```
{{  GReCaptcha::renderJS() }}
```

Paste in form section 
```
{{  GReCaptcha::input() }}
```

Validate in controller 
```
use AAnyszek\GoogleReCaptcha\Rules\GoogleReCaptcha;

$validator = Validator::make($request->all(), [
    'name'         => 'required|max:255',
    'email'        => 'required|email',
    'message'      => 'required',
    'g_site_token' => ['required', new GoogleReCaptcha()]
]);
```

