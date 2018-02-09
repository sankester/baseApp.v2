<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 16/08/2017
 * Time: 08:21
 */

namespace App\Libs\PageLib\Data;


class Breadcumb
{
    private $data = null;

    public function __construct(){}

    public function setBreadcumb(Array $data)
    {
        $defaultIndex = $this->getIndex();
        foreach ($data as $key => $values) {
            if (is_array($values)) {
                $this->pushManyData($values);
            } else {
                $this->pushSingleData($defaultIndex,$key, $values);
            }
        }
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    private function getIndex()
    {
        if (is_null($this->data)) {
            return 0;
        } else {
            $index = count($this->data);
            return $index;
        }
    }
    /**
     * @param $values
     * @param $key
     */
    private function pushSingleData($index,$key, $values)
    {
        $this->data[$index][$key] = $values;
    }

    private function pushManyData($params)
    {
        $index = $this->getIndex();
        foreach ($params as $key => $values) {
            $this->pushSingleData($index,$key, $values);
        }
    }

    public function generateBreadcumb()
    {
        if(!is_null($this->data)){
            $stringBreadcumb = '<ul class="breadcrumb">'.PHP_EOL;
            $last_key = count($this->data) - 1;
            foreach ($this->data as $key => $item) {
                if($key == $last_key){
                    $stringBreadcumb .= '<li class="active"><i class="'.(isset($item['icon'])?$item['icon']:'').' position-left"></i>'.(isset($item['title']) ? $item['title']:'').'</li>'.PHP_EOL;
                }else{
                    $stringBreadcumb .= '<li><a href="'.url(isset($item['url'])?$item['url']:'#').'"><i class="'.(isset($item['icon'])?$item['icon']:'').' position-left"></i>'.(isset($item['title'])? $item['title']:'').'</a></li>'.PHP_EOL;
                }
            }
            $stringBreadcumb .='</ul>'.PHP_EOL;
            return $stringBreadcumb;
        }else{
            return '';
        }
    }

}