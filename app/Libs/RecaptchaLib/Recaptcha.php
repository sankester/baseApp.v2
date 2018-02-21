<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 08/09/2017
 * Time: 14:55
 */

namespace App\Libs\RecaptchaLib;


use App\Libs\RecaptchaLib\Data\RecaptchaProperty;
use GuzzleHttp\Client;

class Recaptcha
{
    protected static $recaptchaProperty = null;

    public static function validateRecaptcha($value){

        self::setRechaptchaProperty();
        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=> self::$recaptchaProperty->getSecretKey()->pref_value,
                    'response'=>$value
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

    public static function generateCaptcha()
    {
        self::setRechaptchaProperty();

        return '<div class="g-recaptcha"
           data-sitekey="'.self::$recaptchaProperty->getSiteKey()->pref_value.'" >
        </div>';
    }


    public static function getRecaptchaJs()
    {
        return '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
    }

    public static function setRechaptchaProperty()
    {
        if (is_null( self::$recaptchaProperty ) )
        {
            self::$recaptchaProperty = new RecaptchaProperty();
        }

    }
}