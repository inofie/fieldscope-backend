<?php

namespace App\Libraries\Notification;

class Notification implements NotificationInterface
{
    /**
     * This function is used for send web notification
     */
    public function webNotification()
    {
        return new \WebNotification();
    }

    /**
     * This function is used for send push notification on mobile
     * @param $device_type = andriod, ios
     */
    public function pushNotification($type,$notification_data)
    {
        return new PushNotification($type,$notification_data);
    }

    /**
     * this function is used for send email notification
     */
    public function emailNotification($template_identifier,$sender_email,$mail_params)
    {
        return new EmailNotificaiton($template_identifier,$sender_email,$mail_params);
    }

}