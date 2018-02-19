<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 07/09/2017
 * Time: 15:34
 */

namespace App\Libs\LogLib\Data;


/**
 * Class MessageLog
 * @package App\Libs\LogLib\Data
 */
class MessageLog
{
    /**
     * @var
     */
    private $level;
    /**
     * @var
     */
    private $message;
    /**
     * @var
     */
    private $data;
    private $model;
    private $prefix;


    /**
     * @param $level
     * @param $prefix
     * @param $data
     * @param $model
     */
    public function setData($level = '', $prefix, $data, $model)
    {
        $this->level = $level;
        $this->prefix = $prefix;
        $this->data = $data;
        $this->model = $model;
    }

    /**
     * @return bool|string
     */
    public function generateMessage()
    {
        switch($this->level){
            case 'insert' :
                if( $this->cek_data() == true):
                    $this->generateMessageColumnInsert();
                else :
                    break;
                endif;
                break;
            case 'update' :
                if( $this->cek_data() == true):
                    $this->generateMessageColumnUpdate();
                else :
                    break;
                endif;
                break;
            case 'delete' :
                break;
            default :
                break;
        }

        return $this->prefix.$this->message;
    }

    /**
     * @return bool
     */
    private function cek_data()
    {
        if(! empty($this->data)){
            foreach ($this->data as $key => $item) {
                if($this->model->$key != $item){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Generate message untuk insert
     */
    private function generateMessageColumnInsert()
    {
        $this->message = ' ';
        foreach ($this->data as $key => $item) {
            $this->message .= ' <span class="text-muted text-size-small">'.$key.'</span> = <span class="text-muted text-size-small">'.$item.'</span>,';
        }
        $this->message = rtrim($this->message,',');
    }


    /**
     * Generate message
     */
    private function generateMessageColumnUpdate()
    {
        $this->message = ' ';
        foreach ($this->data as $key => $item) {
            if($this->model->$key != $item){
                $this->message .= $key.' dari <span class="text-muted text-size-small">'.$this->model->$key.'</span> menjadi <span class="text-muted text-size-small">'.$item.'</span>,';
            }
        }
        $this->message = rtrim($this->message,',');
    }


}