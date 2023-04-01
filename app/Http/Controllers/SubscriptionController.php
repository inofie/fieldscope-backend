<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Payment\Stripe;
use App\Models\Company;
use App\Models\CompanySubscriptionRelation;
use App\Models\Subscription;
use App\Models\Tag;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class SubscriptionController extends Controller
{

    function __construct()
    {
        $this->_stripe = new Stripe;
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
                'store', 'index', 'show', 'edit', 'update',
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
//        print_r($request->all()); die;
        $list = Tag::getList($request->all());
//        print_r($list); die;
        $this->__is_paginate = true;
        $this->__is_collection = true;
        return $this->__sendResponse('Tag', $list, 200, 'Tag list retrieved successfully.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->__view = 'subadmin/tag';
        $this->__is_redirect = true;

        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['has_qty'] = 'required|int';
        $param_rules['category_id'] = 'required|int';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $tag = new Tag();
        $tag['company_id']  =   $request['company_id'];
        $tag['category_id'] =   $request['category_id'];
        $tag['name']        =   $request['name'];
        $tag['has_qty']     =   $request['has_qty'];

        if (!$tag->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //region Validation Block
        $param_rules['id'] = 'required|exists:user';
        $response = $this->__validateRequestParams(['id' => $request['user_id']], $param_rules);
        if ($this->__is_error == true)
            return $response;
        //endregion

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editTagDetails(Request $request, $id)
    {
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Tag::where($param)->first();

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Tag retrieved successfully.');
    }


    public function subsList(Request $request){

        $this->__view = 'subadmin/subscription_mgmt';

        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $list['subs'] = Subscription::getList($param);

        $list['companySub'] = CompanySubscriptionRelation::where('company_id',$request['company_id'])->first();

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function reSubscriptionView(Request $request){

        $this->__view = 'subadmin/re_subscription';
        $param = $request->all();

        $list['subs'] = Subscription::where('type','<>','free')->get();
//        Helper::pd($list['subs']->toArray());
//        $list['companySub'] = CompanySubscriptionRelation::where('company_id',$request['company_id'])->first();
//        Helper::pd($list['companySub']);

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }


    public function reSubscription(Request $request){

        $this->__view = 'subadmin/subscription';
        $this->__is_redirect = true;
        $param = $request->all();

        //region Validation BLock
        $param_rules['plan'] = 'required|int';
        $param_rules['stripeToken'] = 'required';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Invalid Input' , $error['data']);
            return $response;
        }
        //endregion

        $sub = Subscription::where(['id' => $param['plan']])->first();
        $CompanyPUser = Company::getPrimaryUser($request['company_id']);
        $coSub = CompanySubscriptionRelation::where(['company_id' => $request['company_id']])->first();

        //region Calculations for payment amount
        $reSubAmount = 0;
        $sub['allowed_tiers'] =  $coSub->total_allowed_tiers;

        if ($sub->type == 'basic') {
            $reSubAmount = $sub->amount + ($sub->per_user_amount * $coSub->total_allowed_tiers);

        } else if ($sub->type == 'plus') {
            /** Adjusting for min. user */
            $sub['allowed_tiers'] = ($sub->min_user * ceil($coSub->total_allowed_tiers / $sub->min_user));
            $reSubAmount =  $sub->amount + ($sub->per_user_amount * $sub['allowed_tiers']);
        } else {

        }
        $sub['resub_amount'] = $reSubAmount;
        //endregion

        //region Stripe Block

        $stripeResponse = $this->_stripe->createCustomerNewCard($CompanyPUser['stripe_customer_id'], $request['stripeToken']);

        if ($stripeResponse['code'] != 200) {
            $this->__setFlash('danger', $stripeResponse['message']);
            return $this->__sendError('Stripe Error', ['message' => $stripeResponse['message']]);
        } else {
            // @formatter:off
                $charge_data = [
                    'amount' => $reSubAmount,
                    'currency' => env('STRIPE_CHARGE_CURRENCY'),
                    'source' => $stripeResponse['data']->id,
                    'customer' => $CompanyPUser['stripe_customer_id'],
                    'description' => 'Resubscribe with plan '.$sub['title'],
                    /*'transfer_group' => $transfer_group,*/
                    ];
                // @formatter:on
            $charge = $this->_stripe->createCharge($charge_data);


            if ($charge['code'] != 200) {
                $this->__setFlash('danger', $charge['message']);
                return $this->__sendError('Stripe Error', ['message' => $charge['message']]);
            }


            $sub['transaction_head'] = 'resubscribe';
            $sender = User::getById($request['user_id']);
            Transactions::addSubscriptionPlan($sender, '', $sub, $charge_data, $charge);
            CompanySubscriptionRelation::reSubscribe($param, $sub);
        }
        //endregion

        $this->__setFlash('success', "You're Resubscribed.");
        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

