<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 08/09/2017
 * Time: 15:00
 */

namespace App\Libs\RecaptchaLib\Data;


use App\Repositories\BaseApp\PreferenceRepository;

class RecaptchaProperty
{
    private $siteKey;
    private $secretKey;
    private $repositories;

    public function __construct()
    {
        $this->setRepositories();
        $this->getProperty();
    }


    public function setRepositories()
    {
        $this->repositories = new PreferenceRepository();
    }
    
    public function getProperty()
    {
        $this->siteKey = $this->repositories->getByGroupAndName('recaptcha_api','Site key');
        $this->secretKey = $this->repositories->getByGroupAndName('recaptcha_api','Secret key');

    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return mixed
     */
    public function getSiteKey()
    {
        return $this->siteKey;
    }
}