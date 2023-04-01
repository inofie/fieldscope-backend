<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Helper;
use App\Models\Notification;
use App\Models\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    /**
     * NotificationController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'index' , 'update' , 'unreadCount' , 'index' , 'storeSetting' , 'getSetting' , 'deleteAll'
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
        $list = Notification::where('target_id',$request['user_id'])->orderBy('id','DESC' )->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        return $this->__sendResponse('Notification', $list, 200,'Notification retrieved successfully.');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSetting(Request $request)
    {

        //<editor-fold desc="Validation">
        $param_rules['user_id'] = 'required';
        $param_rules['status'] = 'required|in:0,1';
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;
        //</editor-fold>

        $res = UserSettings::updateOrCreate([
            'setting_id' => 3, //push_notification
            'tenant_id' => $request->user_id],
            ['value' => $request->status]);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Notification', $res->only(['value']), 200,'Your notification has been added successfully.');

    }

    public function getSetting(Request $request)
    {

        //<editor-fold desc="Validation">
        $param_rules['user_id'] = 'required';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;
        //</editor-fold>

        $userSettings = UserSettings::firstOrCreate([
            'setting_id' => 3, //push_notification
            'tenant_id' => $request->user_id],
            ['value' => 1]
        );

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Notification', $userSettings->only(['value']), 200,'Your notification has been added successfully.');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $param_rules['id'] = 'required|exists:notification';

        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        return $this->__sendResponse('Notification', Notification::getById($id), 200,'notification retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Notification::where('id',$id)->update(['is_read' => 1]);
//        Helper::pd(Notification::getById($id) ,'Notification::getById($id)');
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Notification', Notification::getById($id), 200,'Notification retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function unreadCount(Request $request){

//        die('aaa');
        $res = Notification::countUnreadByTargetId($request['user_id']);

//        Helper::pd($res->toArray() ,'$res ');

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Notification', $res, 200,'Unread notification count retrieved successfully.');
    }

    public function deleteAll(Request $request)
    {
        Notification::where('target_id',$request['user_id'])->delete();

        $this->__is_collection = false;
        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Notification', [], 200,'Notification cleared successfully.');
    }
}
