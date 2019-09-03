<?php

namespace AAnyszek\GoogleReCaptcha\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class GoogleReCaptcha implements Rule
{
    private $secretKey;
    private $minScore;

    private $errorMessage = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->secretKey = config('g-re-captcha.prv_key');
        $this->minScore  = config('g-re-captcha.min_score', 0.7);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (\App::runningUnitTests()) {
            Log::info('Laravel running test, return true');
            return true;
        }

        $this->errorMessage = null;
        $ch                 = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query([
                "secret"   => $this->secretKey,
                "response" => $value
            ]));

        $response = curl_exec($ch);
        $data     = json_decode($response, true);

        if (!isset($data["success"]) || $data["success"] == false) {
            Log::warning('ReCaptcha fail: ', $data);
            $this->errorMessage = trans('g-re-captcha::captcha.fail');
            return false;
        }

        if (($data["success"] == true) && ($data["score"]) >= $this->minScore) {
            return true;
        }

        Log::warning('ReCaptcha negative: ', $data);
        $this->errorMessage = trans('g-re-captcha::captcha.negative');
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
