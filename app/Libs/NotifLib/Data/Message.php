<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 23/02/2018
 * Time: 08:50
 */

namespace App\Libs\NotifLib\Data;


class Message
{
    /**
     * Type message : ['info','success','danger','warning']
     * @var string
     */
    protected $type;

    protected $scopeType = ['danger', 'success', 'warning', 'info'];

    /**
     * Message Text
     * @var string
     */
    protected $message;

    /**
     * @var
     */
    protected $important = false;

    /**
     * @return mixed
     */
    public function isImportant()
    {
        return $this->important;
    }

    /**
     * @param mixed $important
     */
    public function setImportant($important)
    {
        $this->important = $important;
    }

    /**
     * With error status
     * @var bool
     */
    protected $error = false;

    /**
     * Message constructor.
     * @param string $type
     * @param string $message
     * @param bool $error
     */
    public function __construct($type = '', $message = '', $error =  false)
    {
        $this->type = $type;
        $this->message = $message;
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        if (in_array($type, $this->scopeType)) :
            $this->type = $type;
        else :
            $this->type = 'info';
        endif;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error)
    {
        $this->error = $error;
    }

}