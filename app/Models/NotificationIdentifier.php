<?php

namespace App\Models;

use App\Libraries\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Notification\Notification;
use App\Models\Notification as NotificationModel;

class NotificationIdentifier extends Model
{
    protected $table = "notification_identifier";

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['identifier','notification_type','send_type','title','message','wildcard','created_at','updated_at','deleted_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function notificationIdentifier($identifier, $data, $custom_data=[], $bulk_notification=false)
    {
        $identifier = self::where('identifier',$identifier)->first();
//        Helper::pd($identifier,'$identifier');
        if(count((array) $identifier))
        {
            if($identifier->notification_type != 'none')
            {
                if($identifier->notification_type == 'push'){
                    self::sendPushNotification($identifier,$data,$custom_data,$bulk_notification);
                }
            }else{
                extract($data);

                $title = $identifier->title;
                eval("\$title = \"$title\";");
                //notitification message
                $message = $identifier->message;
                eval("\$message = \"$message\";");

                NotificationModel::create([
                    'notification_identifier_id' => $identifier->id,
                    'actor_id'                   => $user->id,
                    'target_id'                  => $targetUser->id,
                    'reference_id'               => $referenceId,
                    'reference_module'           => $referenceModule,
                    'type'                       => 'none',
                    'title'                      => $title,
                    'description'                => $message,
                    'created_at'                 => Carbon::now()
                ]);
            }
        }
    }

    public static function sendPushNotification($identifier,$data,$customData = [], $bulk_notification = false)
    {
        //convert array keys in variable

//        pd($data,'$data');

        extract($data);


        //notification title
        $title = $identifier->title;
        eval("\$title = \"$title\";");
        //notitification message
        $message = $identifier->message;
        eval("\$message = \"$message\";");
        //device token
        if($bulk_notification == false){
            $notifyUser   = $identifier->send_type == 'actor' ? $user : $targetUser;
            $device_token = $notifyUser->device_token;
        }else{
            $notifyUsers   = $identifier->send_type == 'actor' ? $user : $targetUser;
            foreach($notifyUsers as $notifyUser)
            {
                $device_token[] =  $notifyUser->device_token;
            }
        }


        if(!empty($device_token) && count(((array) $device_token)) > 0)
        {
            $registrations_ids_key = is_array($device_token) ? 'registration_ids' : 'to';
            if($notifyUser->device_type != 'ios'){
                /*Android*/
                $notification_data = [
                    $registrations_ids_key => $device_token,
                    'notification' => [
                        'body' => $message,
                        'sound' => true,
                        'badge' => self::userNotificationBadge($notifyUser->id)
                    ],
                    'data' => [
                        'message'   => [
                            'body'  => $message,
                            'sound' => true,
                        ],
                        'custom_data' => $customData,
                        'identifier'  => $identifier->identifier
                    ]
                ];
            }
            else{
                /*IOS*/
                $notification_data = [
                    $registrations_ids_key => $device_token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $message,
                        'sound' => 'default',
                        'badge' => self::userNotificationBadge($notifyUser->id),
                        'custom_data'  => $customData,
                        'identifier'  => $identifier->identifier
                    ],
                    'priority' => 'high'
                ];
            }


            $notification = new Notification;
            $notification->pushNotification($notifyUser->device_type,$notification_data);

            //save notification data
            if(isset($notificationType)){

                foreach ($notification_db_data AS $key => $item){
                    /*FOr bulk*/

//                    Helper::pd([
//                        'notification_identifier_id' => $identifier->id,
//                        'actor_id'                   => $item->a_id,
//                        'target_id'                  => $item->t_id,
//                        'reference_id'               => $item->product_id,
//                        'reference_module'           => $referenceModule,
//                        'type'                       => 'push',
//                        'title'                      => $title,
//                        'description'                => $message,
//                        'created_at'                 => Carbon::now()
//                    ]);

                    NotificationModel::create([
                        'notification_identifier_id' => $identifier->id,
                        'actor_id'                   => $item->a_id,
                        'target_id'                  => $item->t_id,
                        'reference_id'               => $item->product_id,
                        'reference_module'           => $referenceModule,
                        'type'                       => 'push',
                        'title'                      => $title,
                        'description'                => $message,
                        'created_at'                 => Carbon::now()
                    ]);
                }

            }else{

                NotificationModel::create([
                    'notification_identifier_id' => $identifier->id,
                    'actor_id'                   => $user->id,
                    'target_id'                  => $notifyUser->id,
                    'reference_id'               => $referenceId,
                    'reference_module'           => $referenceModule,
                    'type'                       => 'push',
                    'title'                      => $title,
                    'description'                => $message,
                    'created_at'                 => Carbon::now()
                ]);
            }

        }
    }

    /**
     * This function is used for count user notification badge
     * @param {int} $user_id
     */
    public static function userNotificationBadge($user_id)
    {
        return 0;
        exit;
        return \DB::table('notification')->where('target_id',$user_id)->where('is_read',0)->count();
    }
}
