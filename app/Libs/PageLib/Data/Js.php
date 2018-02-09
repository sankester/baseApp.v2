<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 13/08/2017
 * Time: 10:01
 */

namespace App\Libs\PageLib\Data;


/**
 * Class Js
 * @package app\AlmuhsinLibs\PageLib
 */
class Js
{

    /**
     * Data JS
     * @var array
     */
    public $data = array();
    /**
     * Name JS
     * @var
     */
    public $name;
    /**
     * Path JS
     * @var
     */
    public $path;

    /**
     * Type link js
     * @var bool
     */
    public $link = false;

    /**
     * Set data JS
     * @param $url
     * @param bool $link
     */
    public function setData($url, $link = false)
    {
        $breakWord = '/';
        $dataJs = str_split($url, strrpos($url, $breakWord) + strlen($breakWord));
        $this->data['FilePath'] =   $dataJs[0];
        $this->data['FileName'] =   $dataJs[1];
        $this->data['FileUrl'] =  $url;
        $this->link = $link;
        $this->path = $this->data['FilePath'];
        $this->name = $this->data['FileName'];
    }

    /**
     * Mengambil nama JS
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Mengambil Path JS
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Mengabil Data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Mengambil format include file JS
     * @return string
     */
    public function getViewJs()
    {
        if($this->link == true){
            $url ='<script type="text/javascript" src="'.$this->data['FileUrl'].'"></script>'.PHP_EOL;
        }else{
            $url ='<script type="text/javascript" src="'.asset($this->data['FileUrl']).'"></script>'.PHP_EOL;
        }
        return $url;
    }

}