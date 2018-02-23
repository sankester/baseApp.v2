<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 23/02/2018
 * Time: 08:54
 */

namespace App\Libs\NotifLib\Data;


use function Composer\Autoload\includeFile;

class NotificationApp
{
    protected $message;

    protected $layout;

    protected $session;

    public function __construct()
    {
        $this->session = new NotificationSession();
    }

    // set notification
    public function setNotification(Message $message)
    {
        $this->message =  $message;
        $this->session->setNotificationSession($this->message);
    }

    // generate notification
    public function clearNotification()
    {
        $this->session->deleteNotificationSession();
        $this->message = new Message();
    }

}