<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = "transactions";

    protected $fillable = ['sender_id', 'receiver_id', 'admin_id', 'transaction_type', 'transaction_mode', 'transaction_head', 'amount', 'gateway_request', 'gateway_response', 'gateway_type', 'created_at', 'updated_at'];


    public static function addSubscriptionPlan($sender, $receiver = '', $subscription, $gateway_request, $gateway_reponse)
    {
        // @formatter:off
        $insert = [
            'sender_id' => $sender->id,
            'receiver_id' => 0,
            'admin_id' => 1,
            'transaction_type' => 'credit',
            'transaction_mode' => 'default',
            'transaction_head' => !empty( $subscription['transaction_head'] )? $subscription['transaction_head'] : 'signup',
            'amount' => !empty($subscription['resub_amount']) ? $subscription['resub_amount'] : $subscription['amount'] , /** calculated value -> $subscription['resub_amount'] */
            'gateway_request' => json_encode($gateway_request),
            'gateway_response' => json_encode($gateway_reponse),
            'gateway_type' => 'stripe',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // @formatter:on
        return self::insert($insert);
    }

    public static function addUser($sender, $receiver = '', $subscription, $gateway_request, $gateway_response)
    {
        // @formatter:off
        $insert = [
            'sender_id' => $sender->id,
            'receiver_id' => 0,
            'admin_id' => 1,
            'transaction_type' => 'credit',
            'transaction_mode' => 'default',
            'transaction_head' => 'user',
            'amount' => $subscription->plan_per_user_amount,
            'gateway_request' => json_encode($gateway_request),
            'gateway_response' => json_encode($gateway_response),
            'gateway_type' => 'stripe',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // @formatter:on
        return self::insert($insert);
    }

}
