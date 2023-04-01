<?php

namespace App\Libraries\Notification;

interface NotificationInterface
{
    public function webNotification();

    public function pushNotification($type,$notification_data);

    public function emailNotification($template_identifier,$sender_email,$mail_params);
}