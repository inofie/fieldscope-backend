<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\JobScope;
use App\Libraries\Helper;
use App\Libraries\Payment\BrainTree;
use App\Libraries\Payment\Stripe;
use App\Models\Company;
use App\Models\CompanyGroup;
use App\Models\CompanySubscriptionRelation;
use App\Models\Donation;
use App\Models\EvProduct;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserWishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->_stripe = new Stripe;

        $this->middleware([LoginAuth::class ] , ['only' => [
            'storeCompany',
            'inspectorUserList',
            'storeInspector',
            'updateInspector',
            'deleteInspector',
            'show',
            'edit',
            'updateBusiness',
            'updateListner',
            'changePassword',
            'getSetting',
            'profile',
            'updateSetting',
            'updateLocation',
            'userSubscription',
            'subscription',
            'increaseDealQuota',
            'addCompanyDonation',
            'paymentProcess',
            'storeAgent',
            'updateAgent',
            'inspectorList',
            'settings',
            'settingsUpdate'
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

        $param['user_group_id'] = isset($request['user_group_id']) ? $request['user_group_id'] : 3;
        $param['name'] = isset($request['name']) ? $request['name'] : '';
        $param['latitude'] = isset($request['latitude']) ? $request['latitude'] : '';
        $param['longitude'] = isset($request['longitude']) ? $request['longitude'] : '';
        $param['radius'] = isset($request['radius']) ? $request['radius'] : 500;

        $list = User::getUserList($param);

        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inspectorUserList(Request $request)
    {
        $param['company_id'] = $request['company_id'];
        $param['user_group_id'] = 2;
        $param['name'] = isset($request['name']) ? $request['name'] : '';
        $param['keyword'] = isset($request['keyword']) ? $request['keyword'] : '';
        $list['inspector'] = User::getInspectorUserList($param);

        $list['companyGroup'] = CompanyGroup::where(['company_id' => $request['company_id']])->get();
        $this->__view = 'subadmin/inspect-user_mgmt';

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function inspectorUserDatatable(Request $request)
    {
        $params = $request->all();
//        Helper::pd($params,'$params');
        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];
        $params['parent_id'] = 0;
        $params['paginate'] = TRUE;
        $params['company_id'] = $request['company_id'];
        $params['user_group_id'] = 2;
        $params['type'] = 1;
        $params['keyword'] = $request['keyword'];

//        $dataTableRecord = Category::areaDatatable($params);

        $dataTableRecord = User::inspectorDatatable($params);
//        Helper::pd($dataTableRecord['records']->toArray(),'$dataTableRecord');

        // set data grid output
        $records["data"] = [];
        if (count(((array) $dataTableRecord['records']) )) {

            foreach ($dataTableRecord['records'] as $record) {
                $options = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"
                data-id="' . $record->id . '"><i class="fa fa-edit"></i> </a>';
                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger"
                data-module="require_photo" data-id="' . $record->id . '" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $records["data"][] = [
                    'id' => $record->id,
                    'name' => $record->full_name,
                    'email' => $record->email,
                    'mobile_no' => $record->mobile_no,
                    'user_type' => $record->group_title,
                ];
            }
        }
        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeCompany(Request $request)
    {
        $param_rules['name'] = 'required|string|max:100';
//        $param_rules['email']           = 'required|unique:user|string|email|max:150|unique:user,deleted_at,NULL';
        $param_rules['email'] = 'required|email';
        $param_rules['mobile_no'] = 'required|string';


        $param_rules['password'] = 'required|string|min:6|confirmed';
        $param_rules['device_type'] = 'required|string';
        $param_rules['device_token'] = 'required|string';
        $param_rules['device'] = 'required|nullable|string';

        $param_rules['image_url'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

//        $param_rules['city']            = 'nullable|string';
//        $param_rules['state']           = 'nullable|string';
//        $param_rules['website']         = 'nullable|string';
//        $param_rules['description']     = 'nullable|string';
//        $param_rules['address']         = 'required|string';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        // $request['password'] = $this->__encryptedPassword($request['password']);

        //$obj_user = User::find($request['user_id']);
        if ($request->hasFile('image_url')) {
            // $obj is model
            $request['system_image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                md5($request['email'] . $request['device_token']),
                Config::get('constants.USER_IMAGE_PATH')
            );
            //$obj_user->image_url = $request['system_image_url'];
        }

        User::updateFields(
            ['device_token' => $request['device_token'] . '_old'],
            ['device_token' => $request['device_token']]
        );

        $userId = User::createAccount($request->all());
        $companyUser = User::getCompany($userId);

        $this->__is_paginate = false;
        $this->__is_collection = false;

        return $this->__sendResponse('Company', $companyUser, 200, 'Company User has been added successfully.');
    }

    public function storeInspector(Request $request)
    {

//        vd(CompanySubscriptionRelation::doesCompanyHasUser($request->all()),'CompanySubscriptionRelation::doesCompanyHasUser($request->all())');
        $this->__view = 'subadmin/inspect_user';
        $this->__is_redirect = true;


        //region Validation
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['email'] = 'required|unique:user|string|email|max:150|unique:user,deleted_at,NULL';
//        $param_rules['email']       = 'required|email';
        $param_rules['mobile_no'] = 'required|string';
        $param_rules['password'] = 'required|string|min:6|confirmed';
        $param_rules['company_group_id'] = 'required|int';
        $param_rules['stripeToken'] = 'required|string|max:100';
//        $param_rules['device_type']     = 'required|string';
//        $param_rules['device_token']    = 'required|string';
//        $param_rules['device']          = 'required|nullable|string';
//        $param_rules['image_url']       = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Added Successfully', $error['data']);
            return $response;
        }
        //endregion

        /*stripe Charge for adding user*/
        /** Check if user adding will exceed the total tier limit
         *  IF Yes: (create user after stripe per user transaction)
         *      - Get user customer_id from db
         *      - stripe token from form
         *      - amount from sub-plan (may be validation for total tiers)
         *      - make transaction
         *      - save in transaction table of db
         */


        $sub = CompanySubscriptionRelation::getByCompanyId($request->all());
        $cUserCount = User::countAppUser($request->all());

        if($sub['plan_type'] == 'free' && $sub['total_allowed_tiers'] <= $cUserCount){
            $this->__setFlash('danger', "Free Accounts can only have 1 inspector user. Subscribe to add more inspectors");
            return $this->__sendError('Validation Error', ['message' => "Free Accounts can only have 1 inspector user. Subscribe to add more inspectors"]);
        }


        if ($sub['total_allowed_tiers'] <= $cUserCount) {
            $CompanyPUser = Company::getPrimaryUser($request['company_id']);

            if($sub['plan_per_user_amount'] > 0 ) {
                //region Stripe Block
                $stripeResponse = $this->_stripe->createCustomerNewCard($CompanyPUser['stripe_customer_id'], $request['stripeToken']);

                if ($stripeResponse['code'] != 200) {
                    die('end 4'.$stripeResponse['message']);
                    $this->__setFlash('danger', $stripeResponse['message']);
                    return $this->__sendError('Stripe Error', ['message' => $stripeResponse['message']]);
                } else {
                    // @formatter:off
                    $charge_data = [
                        'amount' => $sub['plan_per_user_amount'],
                        'currency' => env('STRIPE_CHARGE_CURRENCY'),
                        'source' => $stripeResponse['data']->id,
                        'customer' => $CompanyPUser['stripe_customer_id'],
                        'description' => 'Charge for adding inspector via plan '.$sub['plan_title'],
                        /*'transfer_group' => $transfer_group,*/
                    ];
                    // @formatter:on
                    $charge = $this->_stripe->createCharge($charge_data);

                    if ($charge['code'] != 200) {
                        die('end 5'.$charge['message']);
                        $this->__setFlash('danger', $charge['message']);
                        return $this->__sendError('Stripe Error', ['message' => $charge['message']]);
                    }

                    $sender = User::getById($request['user_id']);
                    Transactions::addUser($sender, '', $sub, $charge_data, $charge);
                    CompanySubscriptionRelation::where(['company_id' => $request['company_id'] ])->increment('total_allowed_tiers');
                }
                //endregion
            }
        }

        $request['user_group_id'] = 2;
        $request['password'] = $this->__encryptedPassword($request['password']);


        //region Image FileUPload
        if ($request->hasFile('image_url')) {
            // $obj is model
            $request['system_image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                md5($request['email'] . $request['device_token']),
                Config::get('constants.USER_IMAGE_PATH')
            );
        }
        //endregion

        User::updateFields(
            ['device_token' => $request['device_token'] . '_old'],
            ['device_token' => $request['device_token']]
        );



        $userId = User::createAccount($request->all());
        $companyUser = User::getCompany($userId);

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;

        return $this->__sendResponse('Company', $companyUser, 200, 'User has been added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeAgent(Request $request)
    {
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['email'] = 'required|unique:user|email|max:150|unique:user,deleted_at,NULL';
        $param_rules['email'] = 'required|email';
        $param_rules['mobile_no'] = 'nullable|string|max:20|unique:user,mobile_no';
        $param_rules['image_url'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $param_rules['password'] = 'required|string|min:6';
        $param_rules['confirm_password'] = 'required_with:password|same:password|string|min:6';
        $param_rules['date_of_join'] = 'required|date_format:"Y-m-d"';
        //$param_rules['device_type'] = 'required|string';
        //$param_rules['device_token'] = 'required|string';
        //$param_rules['device']      = 'required|string';
        //$param_rules['age']      = 'required|int';
        //$param_rules['gender']      = 'required|in:male,female';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        /*$user = User::getByDeviceToken($request['device_token']);
        if($user->count()){
            $this->__is_paginate = false;
            return $this->__sendResponse('User', $user, 200,'User has been added successfully.');
        }*/


        if ($request->hasFile('image_url')) {
            // $obj is model
            $request['system_image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                md5($request['email'] . $request['device_token']),
                Config::get('constants.USER_IMAGE_PATH')
            );
            //$obj_user->image_url = $request['system_image_url'];
        }

        $request['date_of_join'] = date('Y-m-d', strtotime($request['date_of_join']));
        $request['password'] = $this->__encryptedPassword($request['password']);
        $user_id = User::createAgent($request->all());

        //User::createUserSetting($user_id);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        //$this->__collection = false;

        $user = User::getById($user_id);
        //$this->_btAddCustomer($request, $user[0]);

        return $this->__sendResponse('User', $user, 200, 'User has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $param_rules['id'] = 'required|exists:user';

        $response = $this->__validateRequestParams(['id' => $request['user_id']], $param_rules);

        if ($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {

        $param_rules['target_id'] = 'required|exists:user,id';

        if (!isset($request['target_id']))
            $request['target_id'] = $request['user_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['target_id' => $request['target_id']], $param_rules);

        if ($this->__is_error == true)
            return $response;


        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('User', User::getById($request['target_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSetting(Request $request)
    {
        $this->__is_paginate = false;
        return $this->__sendResponse('Settings', User::getUserSetting($request['user_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $param['company_id'] = $request['company_id'];
        $param['id'] = isset($request['id']) ? $request['id'] : $id;
        $param['user_group_id'] = 2;
        $user = User::getUserByIdWithGroup($param);


        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $user, 200, 'User retrieved successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateBusiness(Request $request)
    {
        $param_rules['id'] = 'required|exists:user';
        //$param_rules['address']     = 'nullable|string';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['printer_email_address'] = 'nullable|string|email|max:150';
        //$param_rules['email']       = 'required|string|email|max:150|unique:user';
        //$param_rules['mobile_no'] = 'nullable|string|max:20|unique:user,mobile_no,' . $id;
        $param_rules['password'] = 'nullable|alpha_num|between:6,20';
        //$param_rules['image_url']   = 'nullable';


        $this->__is_ajax = true;
        $request['id'] = $request['user_id'];
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $obj = User::find($request['user_id']);

        if ($request->hasFile('image_url')) {
            // $obj is model
            $obj->image_url = $this->__moveUploadFile(
                $request->file('image_url'),
                $request->user_id . time(),
                Config::get('constants.USER_IMAGE_PATH')
            );
        }

        $name = explode(' ', $request->name);

        $obj->first_name = $name[0];
        unset($name[0]);
        $obj->last_name = isset($name[1]) ? implode(' ', $name) : '';
        if (!empty($request->password))
            $obj->password = $this->__encryptedPassword($request['password']);

        $obj->save();

        Company::where('id', $obj->company_id)
            ->where('primary_user_id', $request['user_id'])
            ->Update([
                'title' => $request['name']
            ]);

        if (isset($request['printer_number']) && !empty($request['printer_number'])) {
            \App\Models\UserSettings::updateSettingvalue([
                'setting_id' => 6,
                'company_id' => $obj->company_id,
                'value' => $request['printer_number'],
            ]);
        }

        if (isset($request['printer_email_address']) && !empty($request['printer_email_address'])) {
            \App\Models\UserSettings::updateSettingvalue([
                'setting_id' => 7,
                'company_id' => $obj->company_id,
                'value' => $request['printer_email_address'],
            ]);
        }

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200, 'User updated successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateAgent(Request $request)
    {
        $request['id'] = $user_id = (isset($request->target_id)) ? $request->target_id : $request['user_id'];
        $param_rules['id'] = 'required|exists:user';
//        $param_rules['name'] = 'required|string|max:100';
//        $param_rules['email']       = 'required|email|max:150|unique:user,email,'.$user_id;
//        $param_rules['date_of_join'] = 'required|date_format:"Y-m-d"';
        $param_rules['mobile_no'] = 'nullable|string|max:20';
        //$param_rules['password'] = 'nullable|alpha_num|between:6,20';
        $param_rules['image_url'] = 'nullable';
        //$param_rules['age']      = 'required|int';
        //$param_rules['gender']      = 'required|in:male,female';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        //$obj = User::where(['company_id' => 15, 'id' => $user_id]); //$request['user_id']

        $name = explode(' ', $request['name']);
        $data = [
            'first_name' => $name[0],
            'last_name' => isset($name[1]) ? $name[1] : '',
//            'email'         => $request['email'],
            'mobile_no' => $request['mobile_no'],
//            'date_of_join'  => $request['date_of_join'],
        ];

        if ($request->hasFile('image_url')) {
            // $obj is model
            $data['image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                $request['user_id'] . time(),
                Config::get('constants.USER_IMAGE_PATH')
            );
        }

        $obj = User::where(['company_id' => $request['company_id'], 'id' => $user_id])->update($data);


        /*$obj->first_name    = $name[0];
        $obj->last_name     = isset($name[1]) ? $name[1] : '';
        $obj->email        = $request->email;*/

        /*if(!empty($request->password))
            $obj->password  = $this->__encryptedPassword($request->password);*/

//        $obj->save();

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('User', User::getById($user_id), 200, 'User updated successfully.');

    }

    public function updateInspector(Request $request, $id)
    {
        $this->__view = 'subadmin/inspect_user?page=' . $request['page'];
        $this->__is_redirect = true;
//        print_r($request->all());
//        die;
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['email'] = 'required|email|max:150|unique:user,email,' . $id . ',id,deleted_at,NULL';
//        $param_rules['email']       = 'required|email';
        $param_rules['mobile_no'] = 'required|string';
        $param_rules['company_group_id'] = 'required|int';

        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Updated Successfully', $error['data']);
            return $response;
        }

        $parsedName = Helper::getTwoPartName($request['name']);
        $update['first_name'] = $parsedName['first_name'];
        $update['last_name'] = $parsedName['last_name'];

        $update['email'] = $request['email'];
        $update['mobile_no'] = $request['mobile_no'];
        $update['company_group_id'] = $request['company_group_id'];
        User::where('id', $id)->update($update);

        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User retrieved successfully.');
    }

    public function deleteInspector(Request $request, $id)
    {

        $request['id'] = $id;
        $param_rules['id'] = 'required|exists:user,id,company_id,' . $request['company_id'];

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Deleted Successfully', $error['data']);
            return $response;
        }
        $d = User::where('id', $id)->delete();

        if (!$d) {
            $error['data'][0] = "Delete Failed ";
            $this->__setFlash('danger', 'Delete Not Successfully', $error['data']);
            return $this->__sendError('Query Error', 'Unable to Delete record.');
        }

        $this->__setFlash('success', 'Deleted Successfully');

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Category', [], 200, 'User deleted successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateSetting(Request $request)
    {
        //$param_rules['id'] = 'required|exists:user';
        $param_rules['setting_id'] = 'required';
        $param_rules['value'] = 'required';


        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        User::updateUserSetting($request->all());

        $this->__is_paginate = false;
        return $this->__sendResponse('Settings', User::getUserSetting($request['user_id']), 200, 'User setting updated successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateLocation(Request $request)
    {
        //$param_rules['id'] = 'required|exists:user';
        $param_rules['latitude'] = 'required';
        $param_rules['longitude'] = 'required';
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $obj = User::find($request['user_id']);

        $obj->latitude = $request->latitude;
        $obj->longitude = $request->longitude;

        $obj->Save();

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200, 'User location updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Login  the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function loginIndex(Request $request)
    {
        //die('loginidex');
        $data = [];
        if ($request->hasSession('error')) {
            $data['error'] = $request->session()->pull('error');
        }
        return view('subadmin.login.index', $data);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        Cookie::forget('remember_me');

        $this->__is_redirect = true;
        $this->__view = 'subadmin/login';

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User has been logged out successfully.');
    }

    public function login(Request $request)
    {
        // dd($request);
        /*dd($this->__encryptedPassword($request->password));
        dd($request->all());*/
//        Log::info('login payload',$request->all());

        $param_rules['email'] = 'required|string|email|max:150';
        $param_rules['password'] = 'required|string';

        $this->__is_redirect = true;
        $this->__view = 'subadmin/login';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $user = User::login($request->email, $this->__encryptedPassword($request->password));

        if ($user->isEmpty()) {
            $errors['email'] = Lang::get('auth.failed');
            return $this->__sendError('Validation Error.', $errors);
        }

        if ($this->call_mode != 'api')
            $this->__setSession('user', $user[0], '');

        User::where(['id' => $user[0]->id])->update(['device_type' => $request->device_type ,'device_token' => $request->device_token]);

        if (!empty($request['remember_me'])) {
            $response = new Response('test');
            $response->withCookie(cookie('remember_me', $request->email, '518400'));

        } else {

        }


        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__view = 'subadmin/user-type';
        return $this->__sendResponse('User', $user[0], 200, 'User has been logged in successfully.');
    }

    public function changeCompanyPassword(Request $request)
    {
        $request['old_password'];
        $request['new_password'];
        $request['new_password_confirmation'];

        $this->__is_redirect = true;
        $this->__view = 'subadmin/change_password';

        $param_rules['old_password'] = 'required|string|min:6|max:50';
        $param_rules['new_password'] = 'required|string|min:6|max:50|confirmed';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Updated Successfully', $error['data']);
            return $response;
        }

        $user = User::loginById($request->user_id, $this->__encryptedPassword($request->old_password));
        if (count(((array) $user) <= 0)) {
            $this->__setFlash('danger', 'User Not Found');
            return $this->__sendError('Validation Error.', $errors);
        }

        $user[0]->password = $this->__encryptedPassword($request->password);
        $user[0]->save();

        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', $list, 200, 'Category added successfully.');
    }

    public function forgotPassword(Request $request)
    {
        if ($this->call_mode == 'admin') {
//            $this->__is_redirect = true;
//            $this->__view = 'subadmin/login';
            $this->__is_ajax = true;

        }

        //<editor-fold desc="Validation">

        $param_rules['email'] = 'required|string|email|max:150';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        //</editor-fold>

        // get data against email address
        $user = User::getByEmail($request->email);

        if (count(((array) $user)) <= 0) {
            $errors['email'] = Lang::get('passwords.user');
            return $this->__sendError('Validation Error.', $errors);
        }


        //region update forgot password hash and update hash date
        $hash = $this->__generateUserHash($request->email);


        User::updateByEmail($request->email, [
            'forgot_password_hash' => $hash,
            'forgot_password_hash_date' => Carbon::now()
        ]);
        //endregion


        $mail_params['USER_NAME'] = $user[0]->first_name . ' ' . $user[0]->last_name;
        $mail_params['CONFIRMATION_LINK'] = url("/user/forgot/password/$hash") ;
        $mail_params['USER_LINK'] = url('/user/login') ;
        $mail_params['APP_NAME'] = env('APP_NAME');

        // make forgot password url and implement its email configuration.
        $this->__sendMail('user_forgot_password', $request->email, $mail_params);

        // send email to user


        $this->__is_paginate = false;
        return $this->__sendResponse('User', $user, 200, $errors['email'] = Lang::get('passwords.sent'));
    }

    public function changePasswordByHash(Request $request)
    {
        //<editor-fold desc="Validation">
        $param_rules['hash'] = 'required';
        $param_rules['password'] = 'required|confirmed|min:6';
//        $param_rules['password_confirmation']   = '';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true) {
            return $response;
        }
        //</editor-fold>


        // get data against email address
        $user = User::getByPasswordHash($request->hash);

        if (count((array) $user) <= 0) {
            $errors['email'] = Lang::get('passwords.hash');
            return $this->__sendError('Validation Error.', $errors);
        }

        $user[0]->password = $this->__encryptedPassword($request->password);
        $user[0]->forgot_password_hash = '';

        $user[0]->save();

        $this->__is_paginate = false;
        return $this->__sendResponse('User', $user, 200, Lang::get('passwords.reset'));
    }

    public function changePassword(Request $request)
    {
        $param_rules['old_password'] = 'required';
        $param_rules['password'] = 'required|confirmed|min:6';
        $param_rules['password_confirmation'] = '';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        // get data against email address
        $user = User::loginById($request->user_id, $this->__encryptedPassword($request->old_password));
        if (count(((array) $user)) <= 0) {
            $errors['password'] = Lang::get('passwords.change_password');
            return $this->__sendError('Validation Error.', $errors);
        }

        $user[0]->password = $this->__encryptedPassword($request->password);

        $user[0]->save();

        $this->__is_paginate = false;
        return $this->__sendResponse('User', $user, 200, Lang::get('passwords.reset'));
    }

    public function changePasswordWeb(Request $request)
    {
        $data = [
            'request' => $request
        ];

        if (isset($request->hash)) {
            $this->__call_mode = 'web';
            $this->__is_ajax = true;
            if (isset($request->password) && isset($request->password_confirmation)) {
                $response = $this->changePasswordByHash($request);
                if($response->original['code'] != 200)
                    $this->__setFlash('danger', 'Not Added Successfully', $response->original['data']);
            }

            if ($response->original['code'] == 200) {
                return view('thankyou', $data);
            } else {
                return redirect('/subadmin/login');
            }
        }


        return view('forgotpassword', $data);
    }

    public function contactUs(Request $request)
    {
        $param_rules['name'] = 'required|string';
        $param_rules['email'] = 'required|string|email|max:150';
        $param_rules['mobile_no'] = 'required|string';
        //$param_rules['subject']     = 'required|string';
        $param_rules['message'] = 'required|string';


        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $mail_params['USER_NAME'] = $request['name'];
        $mail_params['EMAIL'] = $request['email'];
        $mail_params['FROM'] = $request['email'];
        $mail_params['MOBILE_NO'] = $request['mobile_no'];
        $mail_params['SUBJECT'] = 'Application'; //$request['subject'];
        $mail_params['MESSAGE'] = $request['message'];
        $mail_params['APP_NAME'] = env('APP_NAME');

        // send email for contact us.
        $this->__sendMail('admin_contact_us', Setting::getByKey('receive_email')->value, $mail_params);


        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, $errors['email'] = Lang::get('messages.contact'));

    }

    public function social(Request $request)
    {
        //$param_rules['name']          = 'required|string|max:100';
        //$param_rules['email']         = 'required|string|email|max:150';
        $param_rules['social_id']       = 'required';
        $param_rules['social_type']     = 'required|in:facebook,google_plus,twitter';
        //$param_rules['age']           = 'required|int';
        //$param_rules['gender']        = 'required|in:male,female';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $user_response = User::getBySocial($request->all());

        if (count(((array) $user_response))) {
            $this->__is_paginate = false;
            return $this->__sendResponse('User', $user_response, 200, 'User already exists.');
        }

        $param_rules['device_type'] = 'required|string';
        $param_rules['device_token'] = 'required|string';
        $param_rules['device'] = 'required|string';
        //$param_rules['user_group_id']   = 'required|string';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $obj_user = new User();

        $name = explode(' ', isset($request['name']) ? $request['name'] : '');

        $obj_user->first_name = $name[0];
        $obj_user->first_name = $name[0];
        $obj_user->last_name = isset($name[1]) ? $name[1] : '';

        $obj_user->email = isset($request['email']) ? $request['email'] : '';
        $obj_user->image_url = isset($request['image_url']) ? $request['image_url'] : '';

        $obj_user->social_id = $request['social_id'];
        $obj_user->social_type = $request['social_type'];

        $obj_user->user_group_id = 1;
        $obj_user->token = User::getToken();

        $obj_user->save();
        User::createUserSetting($obj_user->id);

        $this->__is_paginate = false;
        //$this->__collection = false;

        $user = User::getById($obj_user->id);
        $this->_btAddCustomer($request, $user[0]);

        return $this->__sendResponse('User', $user, 201, 'Social user has been added successfully.');
    }

    public function paymentProcess(Request $request)
    {

        $param_rules['payment_process'] = 'required|in:subscribe';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $map_payment_process['subscription'] = 'subscription';

        $fn = $map_payment_process[$request['payment_process']];
        return $this->$fn($request);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $result, 200, 'Subscribed to gold membership successfully.');
    }

    public function subscription(Request $request)
    {
        $param_rules['subscription_id'] = 'required';
        $param_rules['payment_token'] = 'required';

        $this->__module = 'admin/';
        $this->__view = 'view/' . $request['user_id'];

        $this->__is_redirect = true;

        if (!isset($request['payment_token']))
            $request['payment_token'] = $request['payment_method_nonce'];

        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        $obj_user = UserSubscription::getByUserId($request['user_id']);
        $last_subscription_id = (isset($obj_user->subscription_id)) ? $obj_user->subscription_id : 1;

        $current_date = new Carbon;
        //if(($current_date <= $obj_user['subscription_expiry_date'] && ($obj_user['total_user_deals']) && ($obj_user['total_user_featured_deals']) || $request['subscription_id'] == 1)){
        if (($current_date <= $obj_user['subscription_expiry_date'] && $last_subscription_id != 1)) {
            //$errors['message'] = 'Already a subscribed member and still have deals in quota';
            $errors['message'] = 'Already a subscribed member';
            /*ignore this condition if customer wants to upgrade its subscription*/
            return $this->__sendError('Validation Error.', $errors);
        }

        $customer = ['test'];

        $ob_braintree = new BrainTree();
        $subscription_detail = Subscription::getById($request['subscription_id']);

        $params = [];
        $params['paymentMethodNonce'] = $request['payment_token'];
        $params['planId'] = $subscription_detail->key;

        $customer = $ob_braintree->customerSubscription($params);
        if ($ob_braintree->is_error == true) {
            $errors['message'] = $ob_braintree->message;
            return $this->__sendError('Validation Error.', $errors);
        }

        $obj_trans = new Transactions();

        $obj_trans->sender_id = $request['user_id'];
        $obj_trans->amount = $subscription_detail->amount;
        $obj_trans->gateway_request = json_encode($request->all());
        $obj_trans->gateway_response = json_encode($customer);
        //$obj_trans->gateway_type = 'payal';

        $obj_trans->save();

        /*$obj_user already define up*/
        $subscription_expiry_date = Carbon::now()->addMonth($subscription_detail->duration)->format('Y-m-d');
        //$obj_user->user_group_id = $request['subscription_id']; //group_id
        //$obj_user->save();

        // user subscription entry
        $user_subscription['user_id'] = $request['user_id'];
        $user_subscription['subscription_id'] = $request['subscription_id'];
        $user_subscription['subscription_expiry_date'] = $subscription_expiry_date;
        $user_subscription['total_user_deals'] = $subscription_detail->total_deals;
        $user_subscription['total_user_featured_deals'] = $subscription_detail->total_featured_deals;
        $obj_user_subscription = UserSubscription::updateSubscription($user_subscription);

        $this->__view = 'view';
        $this->__is_redirect = true;

        $this->__is_paginate = false;
        //$this->__collection = false;
        return $this->__sendResponse('Subscription', Subscription::getByUserId($request['user_id'], $request['subscription_id']), 200, 'Subscribed to ' . $subscription_detail->title . ' membership successfully.');
    }

    public function increaseDealQuota(Request $request)
    {
        $param_rules['amount'] = 'required';
        $param_rules['payment_token'] = 'required';

        if (!isset($request['payment_token']))
            $request['payment_token'] = $request['payment_method_nonce'];

        $this->__module = 'admin/';
        $this->__view = 'donation/charge-manually/' . $request['user_id'];


        //$this->__module = '';
        //$this->__view = 'custom_charge_manually_detail_page';

        $this->__is_redirect = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $request['amount'] = Setting::getByKey('featured_deal_charges')->value;
        $params['paymentMethodNonce'] = $request['payment_token'];
        $params['amount'] = $request['amount'];


        $ob_braintree = new BrainTree();
        $re_bt = $ob_braintree->charge($params);

        if ($ob_braintree->is_error == true) {
            $errors['message'] = $ob_braintree->message;
            return $this->__sendError('Validation Error.', $errors);
        }


        $obj_trans = new Transactions();

        $obj_trans->sender_id = $request['user_id'];
        $obj_trans->receiver_id = 0;
        $obj_trans->amount = $request['amount'];
        $obj_trans->transaction_head = 'featured deal';
        $obj_trans->gateway_request = json_encode($request->all());
        $obj_trans->gateway_response = json_encode($re_bt);
        //$obj_trans->gateway_type = 'payal';

        $obj_trans->save();

        UserSubscription::where('user_id', $request['user_id'])->increment('total_user_featured_deals');

        $this->__view = 'donation';
        $this->__is_redirect = true;

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('UserSubscription', [UserSubscription::getByUserId($request['user_id'])], 200, 'User quota is incremented successfully.');
    }

    public function addCompanyDonation(Request $request)
    {
        $param_rules['amount'] = 'required';
        $param_rules['payment_token'] = 'required';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $params['paymentMethodNonce'] = $request['payment_token'];
        $params['amount'] = $request['amount'];

        $ob_braintree = new BrainTree();
        $re_bt = $ob_braintree->charge($params);

        if ($ob_braintree->is_error == true) {
            $errors['message'] = $ob_braintree->message;
            return $this->__sendError('Validation Error.', $errors);
        }

        $obj_trans = new Transactions();

        $obj_trans->sender_id = $request['user_id'];
        $obj_trans->amount = $request['amount'];
        $obj_trans->transaction_head = 'company donation';
        $obj_trans->gateway_request = json_encode($request->all());
        $obj_trans->gateway_response = json_encode($re_bt);
        //$obj_trans->gateway_type = 'payal';

        $obj_trans->save();


        $obj_donation = new Donation();

        $obj_donation->user_id = $request['user_id'];
        $obj_donation->wishlist_id = 0;
        $obj_donation->target_id = 0;
        $obj_donation->target_type = 'company';
        $obj_donation->amount = $request['amount'];
        $obj_donation->save();

        $this->__is_paginate = false;
        $this->__collection = false;

        return $this->__sendResponse('Transactions', $re_bt, 200, 'Company donation submitted successfully.');
    }

    private function _btAddCustomer(Request $request, $obj_user)
    {
        $ob_braintree = new BrainTree();

        $params['id'] = $obj_user->id;
        $params['firstName'] = $obj_user->first_name;
        $params['lastName'] = $obj_user->last_name;
        $params['email'] = $obj_user->email;

        return $ob_braintree->addCustomer($params);
    }

    public function updateSubscription(Request $request)
    {
        $obj_noti = new Notification();

        $obj_noti->actor_id = 1;
        $obj_noti->target_id = 1;
        $obj_noti->reference_id = 1;
        $obj_noti->type = 'push';
        $obj_noti->title = 'hook';
        $obj_noti->description = json_encode($request->all());
        $obj_noti->is_notify = 1;
        $obj_noti->is_read = 1;
        $obj_noti->is_viewed = 1;

        $obj_noti->save();

        $param_rules['user_id'] = 'required';

        $this->__is_ajax = true;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;


        $this->__is_paginate = false;
        $this->__collection = false;

        return $this->__sendResponse('Transactions', $re_bt, 200, 'Company donation submitted successfully.');
    }

    public function userSubscription(Request $request)
    {
        $param_rules['user_id'] = 'required';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $re = UserSubscription::getByUserId($request['user_id']);

        $this->__is_paginate = false;
        //$this->__collection = false;

        return $this->__sendResponse('UserSubscription', $re, 200, 'User Subscription retrieved successfully.');
    }

    public function inspectorList(Request $request)
    {
//        $param['user_group_id'] = isset($request['user_group_id']) ? $request['user_group_id'] : 3;
//        $param['name'] = isset($request['name']) ? $request['name'] : '';
//        $param['latitude'] = isset($request['latitude']) ? $request['latitude'] : '';
//        $param['longitude'] = isset($request['longitude']) ? $request['longitude'] : '';
//        $param['radius'] = isset($request['radius']) ? $request['radius'] : 500;

//        pd($request->all(),'$request');

        $list = User::where(['company_id' => $request->company_id])->where('id','<>',$request->user_id)->whereNotNull('company_group_id')->get(['id','first_name','last_name']);

        $this->__is_paginate = false;

        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function stripOauth(Request $request)
    {

        $request->session()->put('user_id', $request->input('user_id'));
        return redirect()->away('https://dashboard.stripe.com/oauth/authorize?response_type=code&client_id=' . env('STRIPE_CLIENT_ID') . '&scope=read_write');
    }

    public function stripeAuthorizeUser(Request $request)
    {
        $session_data = $request->session()->all();
        if (!empty($session_data['user_id'])) {
            $code = $request->input('code');
            $token_request_body = array(
                'client_secret' => env('STRIPE_SECRET_KEY'),
                'grant_type' => 'authorization_code',
                'code' => $code,
            );
            $req = curl_init('https://connect.stripe.com/oauth/token');
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true);
            curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
            $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            $resp = json_decode(curl_exec($req), true);
            curl_close($req);
            $stripuserid = $resp['stripe_user_id'];
            //update company strip account id
            User::where('id', $session_data['user_id'])->update([
                'stripe_account_id' => $stripuserid
            ]);
            $request->session()->flush();
            die('Stripe account has been connected successfully');
        }
    }

    public function settings(Request $request)
    {
        $this->__view = 'subadmin/settings';

        $data['company'] = Company::getById($request['company_id']);

        $evProductM = new EvProduct();
        $products = $evProductM->getCompanyProducts_WithSelectedFlag($request->all());
        $data['evProducts'] = array_values($products);

//        pd($data,'$data');
        if(!empty($data['company']['hover_ref_code'])){
            $data['company']['hover_url'] = url("hover/authentication/".$data['company']['hover_ref_code']."/");
        }




        $this->__setSession('user', User::getById($request['user_id']));

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $data, 200, 'Settings Page Load');
    }

    public function settingsUpdate(Request $request)
    {

        $this->__view = 'subadmin/settings';
        $this->__is_redirect = true;

        //<editor-fold desc="Validation">

        $param_rules['crm_email'] = 'nullable|email|';
        $param_rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Settings Not Updated', $error['data']);
            return $response;
        }

        //</editor-fold>

        if ($request->hasFile('logo')) {
            // $obj is model
            $uploadedLogo = $this->__moveUploadFile(
                $request->file('logo'),
                md5($request['email'] . $request['device_token']),
                config('constants.USER_IMAGE_PATH')
            );

            $logoUpdate = User::where(['id' => $request['user_id']])->update(['image_url' => $uploadedLogo]);
        }

        /** CRM Email */
        $crm = new JobScope();
        $response = $crm->authenticate();
        if ($response['code'] != 200) {
            /*IF auth fails*/
            $message = $response['data']['message'];
            $this->__setFlash('danger', "Failed to authenticate CRM. ($message)");
            return $this->__sendError('CRM API Error', "Failed to authenticate CRM. ($message)", '400');
        }

        $crm->getEmployee($request['crm_email']);

//        die('end');

        $update = [
            'crm_employee_email' => $request['crm_email'],
            'crm_employee_id' => $crm->response['data']['id'],
        ];

        $update = Company::where(['id' => $request['company_id']])->update($update);

        if ($update < 0) {
            $this->__setFlash('danger', 'Error while updating');
            return $this->__sendError('DB Error', 'Error while updating', '400');
        }

        $this->__setFlash('success', 'Settings Updated');
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'Settings Page Load');
    }
}
