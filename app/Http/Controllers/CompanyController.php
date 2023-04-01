<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Models\Lead;
use App\Models\Company;
use App\Models\User;
use App\Models\LeadHistory;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'storeStatus', 'index','store', 'storeType', 'statusList', 'typeList', 'updateStatus', 'deleteType'
                            , 'updateStatusValue', 'updateTypeValue', 'deleteStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = User::getCompany(NULL,TRUE);
        //$this->__is_paginate = false;
        return $this->__sendResponse('User', $list, 200,'Company list retrieved successfully.');
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
        $param_rules['email']                   = 'required|email|unique:user,email,NULL,NULL,deleted_at,NULL';
//      $param_rules['email']                   = 'required|email';
        $param_rules['password']                = 'required|string|max:100|confirmed';
        $param_rules['name']                    = 'required|max:100';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $request['password'] = $this->__encryptedPassword($request['password']);
        $id = Company::createAccount($request);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Company', Company::getById($id), 200,'Company has been added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStatus(Request $request)
    {
        $param_rules['title']       = 'required|string|max:100';
        $param_rules['code']        = 'required|string|max:2|unique:status,NULL,deleted_at,id,tenant_id,'.$request['company_id'];
        $param_rules['color_code']  = 'required';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_status = new Status();
        $obj_status->title      = $request['title'];
        $obj_status->tenant_id = $request['company_id'];
        $obj_status->code = $request['code'];
        $obj_status->color_code = $request['color_code'];
        $obj_status->save();

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Status', Status::getById($obj_status->id), 200,'Status has been added successfully.');
    }

    public function updateStatusValue(Request $request)
    {
        $param_rules['id']          = 'required|exists:status,id,tenant_id,'.$request['company_id'];
        $param_rules['title']       = 'required|string|max:100';
        $param_rules['code']        = 'required|string|max:12';
        $param_rules['color_code']  = 'required';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $status_count = Status::getByCode($request['id'], $request['code'], $request['company_id']);

        if($status_count > 0){
            $errors['code'] = 'Code is already been taken';
            return $this->__sendError('Validation Error.', $errors);
        }

        $obj_status = Status::find($request['id']);
        $obj_status->title      = $request['title'];
        $obj_status->code = $request['code'];
        $obj_status->color_code = $request['color_code'];
        $obj_status->save();

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Status', Status::getById($obj_status->id), 200,'Status has been added successfully.');
    }

    public function updateTypeValue(Request $request)
    {
        $param_rules['id']       = 'required|exists:type,id,tenant_id,'.$request['company_id'];
        $param_rules['code']        = 'required|string|max:2';
        $param_rules['title']       = 'required|string|max:100';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $type_count = Type::getByCode($request['id'], $request['code'], $request['company_id']);

        if($type_count > 0){
            $errors['code'] = 'Code is already been taken';
            return $this->__sendError('Validation Error.', $errors);
        }


        $obj_type = Type::find($request['id']);
        $obj_type->code      = $request['code'];
        $obj_type->title      = $request['title'];

        $obj_type->save();

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Status', Status::getById($obj_type->id), 200,'Status has been added successfully.');
    }

    public function deleteStatus(Request $request)
    {
        $param_rules['id']       = 'required|exists:status,id,tenant_id,'.$request['company_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        Status::destroy($request['id']);


        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Status', [], 200,'Status has been deleted successfully.');
    }

    public function deleteType(Request $request)
    {
        $param_rules['id']       = 'required|exists:type,id,tenant_id,'.$request['company_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        Type::destroy($request['id']);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Type', [], 200,'Status has been deleted successfully.');
    }

    public function storeType(Request $request)
    {
        $param_rules['code']        = 'required|string|max:2|unique:type,NULL,deleted_at,id,tenant_id,'.$request['company_id'];
        $param_rules['title']        = 'required|string|max:100';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        
        if($this->__is_error == true)
            return $response;

        $obj_type = new Type();
        $obj_type->title      = $request['title'];
        $obj_type->tenant_id = $request['company_id'];
        $obj_type->code = $request['code'];
        $obj_type->save();

       
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Type', Type::getById($obj_type->id), 200,'Type has been added successfully.');
    }

    public function statusList(Request $request)
    {
        $request['company_id'];

        $status = [$request['company_id']];
        if($this->call_mode != 'api')
            $status = [$request['company_id']];

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        return $this->__sendResponse('Status', Status::whereIn('tenant_id', $status)->whereNull('deleted_at')->get(), 200,'Status list retrieved successfully.');
    }

    public function typeList(Request $request)
    {
        $type = [$request['company_id']];
        if($this->call_mode != 'api')
            $type = [$request['company_id']];

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        return $this->__sendResponse('Type', Type::whereIn('tenant_id', $type)->whereNull('deleted_at')->get(), 200,'Type list retrieved successfully.');
    }


    public function getStatusDetail(Request $request, $id)
    {
        $param_rules['id'] = 'required|exists:status,id';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;


        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;

        //$detail = Status::find($id)->whereIn('tenant_id', ['0', $request['company_id']])->whereNull('deleted_at')->get();
        $detail = Status::where('id',$id)->whereIn('tenant_id', ['0', $request['company_id']])->whereNull('deleted_at')->first();
        return $this->__sendResponse('Status', $detail, 200,'Status list retrieved successfully.');
    }

    public function getTypeDetail(Request $request, $id)
    {
        $request['company_id'];
        $param_rules['id'] = 'required|exists:type,id';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;


        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;

        return $this->__sendResponse('Type', Type::where('id',$id)->whereIn('tenant_id', ['0', $request['company_id']])->whereNull('deleted_at')->first(), 200,'Type list retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

    public function updateStatus(Request $request)
    {

        $param_rules['lead_id'] = 'required|exists:lead,id';
        $param_rules['status_id'] = 'required|exists:status,id';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_lead = Lead::find($request['lead_id']);
        $status_id = $obj_lead->status_id;
        $obj_lead->assignee_id = $request['user_id'];
        $obj_lead->status_id = $request['status_id'];
        $obj_lead->save();

        if($status_id != $request['status_id']) {
            $obj_lead_history = new LeadHistory();

            $obj_lead_history->lead_id = $request['lead_id'];
            $obj_lead_history->assign_id = $request['user_id'];
            $obj_lead_history->status_id = $obj_lead->status_id;
            $obj_lead_history->save();

            Status::incrementLeadCount($obj_lead->status_id);
            Status::decrementLeadCount($status_id);
        }


        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($request['lead_id']), 200,'Lead has been retrieved successfully.');
    }
}
