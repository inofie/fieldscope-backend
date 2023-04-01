<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Models\Category;
use App\Models\ProjectShareMedia;
use App\Models\Lead;
use App\Models\ProjectShare;
use App\Models\UserLeadAppointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectShareController extends Controller
{
    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => ['index' ,'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectShare = ProjectShare::getBy(['creator_id' => $request->user_id],['project']);
        
        if(!empty($projectShare['error'])){
            return $this->__sendError('Error',"You haven't shared any links.",400);
        }

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('ProjectShare', $projectShare[0], 200,  __('app.success_listing_message'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //<editor-fold desc="Validation">
        $param_rules['project_id'] = [
            'required', Rule::exists('project','id')->where(function($q){ $q->whereNull('deleted_at'); }),
        ];
        $param_rules['user_id'] = ['numeric', 'required_without:email' , Rule::exists('user','id')->where(function($q){ $q->whereNull('deleted_at'); })];
        $param_rules['email'] = 'email|required_without:user_id';
        $param_rules['media_ids'] = 'required|array|distinct';
        $param_rules['media_ids.*'] = 'required|numeric|distinct';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;
        //</editor-fold>

        $res = ProjectShare::createShare($request->all());

        if($res['error']){
            return $this->__sendError('Error',$res['error'],400);
        }

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('UserLeadAppointment', [], 200, __('app.success_store_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //<editor-fold desc="Validation">
        $request['project_share_id'] = $id;
        $param_rules['project_share_id'] = [
            'required', Rule::exists('project_shares','id')->where(function($q){ $q->whereNull('deleted_at'); }),
        ];
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;
        //</editor-fold>

        $projectShare = ProjectShare::getBy(['id' => $id],['project','media']);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('ProjectShare', $projectShare[0], 200,  __('app.success_show_message'));
    }

    public function photos(Request $request, $token)
    {
        $projectShare = ProjectShare::getBy(['share_token' => $token]);

        $data['projectShare'] = $projectShare[0];
        $data['category'] = Category::where(['company_id' => $projectShare[0]['company_id'] , 'parent_id' => 0])->where('type','<>',3)->get(['id','name']);
        $data['media'] = ProjectShareMedia::getMedia_byShare($projectShare[0],$request->all());

        $this->__view = 'web.project_share_list';
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('ProjectShare', $data, 200,  __('app.success_show_message'));
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
        //<editor-fold desc="Validation">
        $request['project_share_id'] = $id;
        $param_rules['project_share_id'] = [
            'required', Rule::exists('project_shares','id')->where(function($q){ $q->whereNull('deleted_at'); }),
        ];
        $param_rules['status'] = 'required|in:active,inactive';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;
        //</editor-fold>

        $res = ProjectShare::changeStatus($id,$request->status);

        if($res['error']){
            return $this->__sendError('Error',$res['error'],400);
        }

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('UserLeadAppointment', [], 200, __('app.success_update_message'));
    }
}
