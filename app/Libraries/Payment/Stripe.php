<?php

namespace App\Libraries\Payment;


class Stripe
{
    private $_stripe_obj,$_response;

    public function __construct()
    {
        $this->_response = [
            'code'    => 200, //status code
            'message' =>'success', //message
            'data' => [] //data
        ];
    }

    /**
     * This function is used for create customer on stripe
     * @param string $email
     * @return array
     */
    public function createCustomer($email)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer = \Stripe\Customer::create([
                "email" => "$email" // obtained with Stripe.js
            ]);
        }catch (\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Customer added successfully', //message
            'data' => [
                'customer_id' => $customer->id
            ] //data
        ];
    }

    /**
     * This function is used for update customer on stripe
     * @param string $customer_id
     * @param string $card_token
     * @return array
     */
    public function updateCustomer($customer_id,$card_token)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer = \Stripe\Customer::update(
                $customer_id,
                [
                    'source' => $card_token,
                ]
            );
        }catch (\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Customer updated successfully', //message
            'data' => [
                'customer' => $customer
            ] //data
        ];
    }

    public function createSource($card_token)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $source = \Stripe\Source::create([
                "type" => "card",
                "token" => $card_token
            ]);
        }catch(\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Customer updated successfully', //message
            'data' => [
                'source_id' => $source->id
            ] //data
        ];
    }

    /**
     * This function is used for add multiple user card
     * @param {string} $stripe_customer_id
     * @param {string} $card_token
     */
    public function createCustomerNewCard($stripe_customer_id,$card_token)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $card = \Stripe\Customer::createSource(
                $stripe_customer_id,
                [
                    'source' => $card_token,
                ]
            );
        }catch (\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Card added successfully', //message
            'data' => [
                'card' => $card
            ] //data
        ];
    }

    public function getUserStripeCardList($strip_customer_id)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $cards = \Stripe\Customer::allSources(
                $strip_customer_id,
                [
                    'limit' => 10,
                    'object' => 'card',
                ]
            );
        }catch(\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Cards retrieved successfully', //message
            'data' => [
                'cards' => $cards
            ] //data
        ];
    }

    /**
     * This function is used for create charge
     * @param {array} $data
     * @return {array}
     */
    public function createCharge($data)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $charge = \Stripe\Charge::create([
                "amount"      => $data['amount'] * 100,
                "currency"    => $data['currency'],
                "source"      => $data['source'],
                "customer"    => $data['customer'],
                "description" => $data['description']
            ]);
        }catch(\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Transactions completed successfully', //message
            'data' => [
                'charge' => $charge
            ] //data
        ];
    }

    public function createCustomerCharge($data)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $charge = \Stripe\Charge::create(array(
                "amount"         => $data['amount'] * 100,
                "currency"       => $data['currency'],
                "source"         => $data['token'],
                "description"    => $data['description'],
                "transfer_group" => $data['transfer_group'],
            ));
        }catch (\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Transactions completed successfully', //message
            'data' => [
                'charge' => $charge->id
            ] //data
        ];
    }

    /**
     * This function is used for transfer
     * @param $data
     */
    public function transfer($data)
    {
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $transfer = \Stripe\Transfer::create(array(
                "amount" => $data['amount'] * 100,
                "currency" => $data['currency'],
                "destination" => $data['destination'],//'acct_1EdE1NLBq37AWvff',
                "transfer_group" => $data['transfer_group'], //unique identifier
            ));
        }catch(\Exception $e){
            return $this->_response = [
                'code'    => 400, //status code
                'message' => $e->getMessage(), //message
            ];
        }
        return $this->_response = [
            'code'    => 200, //status code
            'message' =>'Transactions completed successfully', //message
            'data' => [
                'transfer' => $transfer
            ] //data
        ];
    }
}