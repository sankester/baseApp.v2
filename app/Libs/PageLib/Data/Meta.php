<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 14/08/2017
 * Time: 08:35
 */

namespace App\Libs\PageLib\Data;


/**
 * Class Meta
 * @package app\Libs\PageLib\Data
 */
class Meta
{
    /**
     * Store meta
     * @var array
     */
    private $metaData= array();

    /**
     * Meta constructor.
     * @param array $metaData
     */
    public function __construct($metaData = null)
    {
        $this->setMetaData($metaData);
    }

    /**
     * Get meta data
     * @return array
     */
    public function getMetaData()
    {
        return $this->metaData;
    }

    /**
     * Set metadata
     * @param array $metaData
     */
    public function setMetaData($metaData)
    {
        if( !empty($metaData)){
            $this->metaData = $metaData;
        }
    }

    /**
     * Menampilkan view meta
     * @return string
     */
    public function getViewMeta()
    {
        $stringMeta = '<meta ';
        foreach ($this->metaData as $keyMeta => $metaItem) {
            $stringMeta .= $keyMeta.'="'.$metaItem.'" "';
        }
        $stringMeta .=  '/>'.PHP_EOL;
        return $stringMeta;
    }
}