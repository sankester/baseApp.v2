<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 23/02/2018
 * Time: 08:57
 */

namespace App\Libs\NotifLib\Data;


use Illuminate\Support\Facades\Session;

class NotificationSession
{
    // set name session
    private $session_name = 'app_notification';

    // set session
    public function setNotificationSession(Message $message)
    {
        Session::flash($this->session_name, $message);
    }

}