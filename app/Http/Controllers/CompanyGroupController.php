<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Helper;
use App\Libraries\Payment\BrainTree;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyGroup;
use App\Models\CompanyGroupCategory;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserWishlist;
use Carbon\Carbon;
use Couchbase\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class CompanyGroupController extends Controller
{
    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'storeCompany', 'storeInspector', 'show', 'edit', 'getSetting'
            , 'profile', 'updateSetting', 'updateLocation', 'userSubscription', 'subscription','index']]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
        $param['company_id'] = $request['company_id'];

        $list = CompanyGroup::getCompanyGroupList($param);

        if($this->call_mode == 'admin'){
            $this->__view = 'subadmin.user_type_mgmt';
        }
        $this->__is_paginate = true;
        $this->__is_collection = true;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'User list retrieved successfully.');
    }

    public function companyGroupDatatable(Request $request){
        $params = $request->all();

        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];
        $params['paginate']  = TRUE;
        $params['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
        $params['company_id'] = $request['company_id'];

        $dataTableRecord = CompanyGroup::getCompanyGroupDatatable($params);


        // set data grid output
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'] )))
        {
            foreach($dataTableRecord['records'] as $record){
                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  
                data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" 
                data-module="require_photo" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                if(!empty($record->assigned_user)){
                    $names = $record->assigned_user->map(function($item, $key){
                        return "{$item->first_name} {$item->last_name}";
                    });
                }

                $records["data"][] = [
                    'id' => $record->id,
                    'title' => $record->title,
                    'users' => $names->implode(', ')
                ];

            }


        }
        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function store(Request $request)
    {
        $this->__view = 'subadmin/user-type';
        $this->__is_redirect = true;

        //<editor-fold desc="Validation">
        $param_rules['user_type'] = 'required|string|max:100' ;
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Added Successfully',$error['data']);
            return $response;
        }
        //</editor-fold>

        $companyGroup = new CompanyGroup();
        $companyGroup->title = $request->user_type;
        $companyGroup->company_id = $request->company_id;

        if(!$companyGroup->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        CompanyGroupCategory::insertAdditionalCategory($request->company_id,$companyGroup->id);

        $list = CompanyGroup::getById($companyGroup->id);
        $this->__setFlash('success','Added Successfully');

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $param_rules['id'] = 'required|exists:user';

        $response = $this->__validateRequestParams(['id' => $request['user_id']], $param_rules);

        if($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200,'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $list = CompanyGroup::getById($id);

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $request['id'] = $id;
        $param_rules['user_type'] = 'required|string|max:100' ;
        $param_rules['id'] = 'required|int|' ;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $companyGroup = CompanyGroup::find($id);
        $companyGroup->title = $request->user_type;

        if($this->call_mode == 'admin'){
            $this->__view = 'subadmin/user-type?page='.$request['page'];
            $this->__is_redirect = true;
        }

        if(!$companyGroup->save()){
            $error = \Session::get('error');
            return $this->__sendError('Query Error','Unable to update record.', $error['data'] );
        }

        $list = CompanyGroup::getById($companyGroup->id);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');

    }

    public function delete(Request $request, $id){

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;

        $request['id'] = $id;
//        dd($request->all());
        $param_rules['id'] = [
            'required', 'int',
            Rule::unique('user','company_group_id')->where(function ($q) use($request){
                $q->where('user.company_id', $request['company_id'])
                ->whereNull('user.deleted_at');
            })
        ];

        $customMessages = [
            'id.unique' => "User Type is assigned to a User"
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules,$customMessages);
        dd($response);
        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Deleted Successfully', $error['data']);
            return $response;
        }

        $res = CompanyGroup::destroy($id);;
        if(!$res){
            $error['data'][0] = "Delete Failed ";
            $this->__setFlash('danger','Not Delete Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to Delete record.' );
        }

        $this->__setFlash('success', 'Deleted Successfully');
        return $this->__sendResponse('Tag', [], 200,'User Type deleted successfully.');
    }

}
