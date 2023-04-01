<?php

namespace App\Libraries\Notification;
use Illuminate\Support\Facades\Log;

class PushNotification
{
    /**
     * PushNotification constructor.
     * @param {string} $type = andriod | ios
     * @param {string} $device_token
     * @param {array} $notification_data
     */
    public function __construct($type,$notification_data)
    {
        if($type == 'ios')
            $this->sendPushToIos($notification_data);
        else
            $this->sendPushtoAndroid($notification_data);
    }

    /**
     * This function is used for send push notification to andriod
     * @param {string} $device_token
     * @param {array} $notification_data
     *
     * reference link = https://laravelcode.com/post/laravel-56-google-firebase-notification-in-android
     */


    public function sendPushtoAndroid($notification_data)
    {      
        $fcmUrl = env('FCM_URL');
        $headers = [
            'Authorization: key=' . env('FCM_LEGACY_SERVER_KEY'),
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification_data));
        $result = curl_exec($ch);

        $result = json_decode($result,true);
        if ($result === FALSE)
        {
            Log::error('ERROR - @sendPushtoAndroid: ',$result);
            file_put_contents(base_path('android-notification.txt'),$result);
        }else{
            Log::info('Info - @sendPushtoAndroid: ',$result ?: []);
            Log::info('Info - @sendPushtoAndroid - Payload: ',$notification_data);
        }

        curl_close( $ch );
        return $result;
    }


    /**
     * This function is used for send push notification to andriod
     * @param {string} $device_token
     * @param {array} $notification_data
     *
     * reference link = https://ahex.co/send-push-notification-to-android-and-ios-app-part-1/
     */
    public function sendPushToIos($notification_data)
    {
        $url =  $fcmUrl = env('FCM_URL');
        $json = json_encode($notification_data);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. env('FCM_LEGACY_SERVER_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Send the request
        $result = curl_exec($ch);
        if ($result === FALSE)
        {
            Log::error('ERROR - @sendPushToIos: ',is_array(curl_error($ch)) ? curl_error($ch) :['error' => curl_error($ch)]);
            file_put_contents(base_path('ios-notification.txt'),curl_error($ch));
        }else{
            Log::info('Info - @sendPushToIos: ',$result);
        }
        curl_close( $ch );
        return $result;
    }
}