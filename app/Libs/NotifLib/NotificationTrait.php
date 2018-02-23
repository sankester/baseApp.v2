<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 23/02/2018
 * Time: 08:49
 */

namespace App\Libs\NotifLib;


use App\Libs\NotifLib\Data\Message;
use App\Libs\NotifLib\Data\NotificationApp;
use Illuminate\Notifications\Events\NotificationFailed;

trait NotificationTrait
{
    private $notification;

    private $message;

    public function initializeNotification()
    {
        $this->notification = new NotificationApp();
        $this->message = new Message();
    }

    /**
     * Set Notification
     * @param $message
     * @param string $type
     * @return $this
     */
    public function setNotification($message, $type = 'info'){
        // set message property
        $this->message->setType($type);
        $this->message->setMessage($message);
        $this->initMessage();
        // return
        return $this;
    }

    /**
     * Set info type
     * @return $this
     */
    public function info()
    {
        $this->message->setType('info');
        $this->initMessage();
        return $this;
    }

    /**
     * Set danger type
     * @return $this
     */
    public function danger()
    {
        $this->message->setType('danger');
        $this->initMessage();
        return $this;
    }

    /**
     * Set warning type
     * @return $this
     */
    public function warning()
    {
        $this->message->setType('warning');
        $this->initMessage();
        return $this;
    }

    /**
     * Set success type
     * @return $this
     */
    public function success()
    {
        $this->message->setType('success');
        $this->initMessage();
        return $this;
    }

    /**
     * Wit validation error
     * @return $this
     */
    public function withValidationError()
    {
        //set with error validation
        $this->message->setError(true);
        return $this;
    }

    // init notification
    protected function initMessage(){
        $this->notification->setNotification($this->message);
    }
}