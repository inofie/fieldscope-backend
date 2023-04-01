<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Helper;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectQuery;
use App\Models\Query;
use App\Models\QueryTag;
use App\Models\Tag;
use App\Models\TenantCustomField;
use App\Models\TenantQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class QueryController extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => ['store', 'index', 'update', 'show', 'destroy',
            'queryCreate', 'storeQuery', 'editQueryDetails', 'updateQuery','editSelect'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        print_r($request->all());

        $where['company_id'] = $request['company_id'];
        $where['category_id'] = $request['category_id'];
        $query  = Query::where($where)->get();
//        print_r($query); die;
        $this->__is_paginate = false;
        return $this->__sendResponse('Query', $query, 200,'Query list retrieved successfully.');
    }

    public function queryList(Request $request){
        $this->__view = 'subadmin/questionnaire_mgmt';
        $list['queries'] = Query::getList($request->all());
//        Helper::pd($list['queries'],'$list[\'queries\']');

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function queryDatatable(Request $request){
        $param = $request->all();
//        Helper::p($param,'$param');
        $param['column_index'] = $param['order'][0]['column'];
        $param['sort'] = $param['order'][0]['dir'];


//        Helper::pd($dataTableRecord,'$dataTableRecord');

        if(!empty($param['reOrder'])){
            $reOrderRes = Query::reOrder($param['reOrder'],$param['company_id'],$param['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $dataTableRecord = Query::queryDatatable($param);
//        Helper::pd($dataTableRecord['records']->toArray(),'$dataTableRecord');
        // set data grid output
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'])))
        {
            foreach($dataTableRecord['records'] as $record){
                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="'.URL::to('subadmin/questionnaire/editQuestionnaireDetails/'.$record->id).'"
                data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" 
                data-module="questionnaire" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $records["data"][] = [
                    'id'    => $record->id,
                    'query' => $record->query,
                    'category_name' => $record->category_name,
                    'order_by' => $record->order_by,
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
    public function queryCreate(Request $request)
    {
        $this->__view = 'subadmin.add_questionnaire';
        $list['categories'] = Category::where(['company_id' => $request['company_id'], 'parent_id' => 0 ,'type' => 2])->get();

        //$list['subCategories'] = Category::where(['company_id' => $request['company_id']])->where('parent_id','<>', 0)->get();


//        dd('list',$list);

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function response(Request $request){
        $request['survey'] = json_decode($request['survey'] , true);

        /*Validation */
        $param_rules['project_id'] = 'required|int';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true)
            return $response;

        foreach ($request['survey'] AS $key => $item){
            if (empty($item['id']) || empty($item['query']) || (empty($item['user_response']) && $item['user_response'] == 'text')) {
                return $this->__sendError('Validation Error', 'Invalid Input at index: '.$key);
            }
        }
//        Helper::p($request['survey'],'$request[\'survey\']');
        ProjectQuery::insertSurvey($request['survey'],$request['project_id']);

//        $projectQuery = ProjectQuery::getByProjectId($request['project_id']);
//        Helper::pd($projectQuery->toArray(),'$projectQuery');

        $projectQuery = $request['survey'];

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Query', $projectQuery, 200,'Query Inserted successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeQuery(Request $request)
    {
        \Log::debug("request->all(): ".print_r($request->all(),1));
        $this->__view = 'subadmin/questionnaire?page='.$request['page'];
        $this->__is_ajax = true;
        $this->__collection = false;

        //<editor-fold desc="Validation">
        $param_rules['company_id']      = 'required';
        $param_rules['area']      = 'required|int';
        $param_rules['question']     = 'required|string';
        $param_rules['type']          = 'required';
        $param_rules['is_required']    = 'required|in:true,false';

        $param_rules['options.*']        = 'required_if:type,checkbox,radio|distinct';
        $param_rules['help_photo']        = 'nullable|mimes:jpg,jpeg,png,gif,pdf';
        $param_rules['photo_view']        = 'required_if:type,checkbox,radio';

        $customMessages['options.*.distinct'] = "The options have a duplicate value";
        $customMessages['photo_view.required_if'] = "Photo View field is required";
        $response = $this->__validateRequestParams($request->all(), $param_rules,$customMessages);

        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not added Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        //<editor-fold desc="File Upload">

        $uploadedImage = "";
        if ($request->hasFile('help_photo')) {
            // $obj is model
            $uploadedImage = Helper::uploadFile($request->file('help_photo'), 'sample_query', Config::get('constants.MEDIA_IMAGE_PATH'));
        }
        //</editor-fold>

            $maxCat = Query::where(['company_id' => $request->company_id , 'category_id' => $request['area'] ])->max('order_by');
            $query['company_id']    = $request['company_id'];
            $query['query']         = $request['question'];
            $query['image_url']     = $uploadedImage;
            $query['type']          = $request['type'];
            $query['is_required']   = $request['is_required'] == true ? 1 : 0 ;
            $query['order_by']      = $maxCat + 1;
            $query['category_id']   = $request['area'];
            $query['created_at']    = date('Y-m-d H:i:s');

            $options = $request['options'];

            if (!empty($options) && ($request['type'] == 'text' || $request['type'] == 'date' || $request['type'] == 'sign')) {
                $query['options'] = '';
            } else {
                /** IF checkbox and radio */

                if(in_array('N/A',$options)){
                    $query['photo_view_id'] = !empty($request['photo_view']) ? $request['photo_view']: NULL ;
                }
                $query['options'] = trim(implode(',', $options), ' ,');

                if(empty($query['options'])){
                    $this->__is_paginate = false;
                    $this->__is_collection = false;
                    return $this->__sendError('Required Options Missing.', [], 400);
                }
            }


        \Log::debug("$query: ".print_r($query,1));
            $query = Query::create($query);

        if(empty($query)){
            return $this->__sendError("Error While Adding Questions",[],400);
        }

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Query', [], 200, 'Your question has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $table_map['summary'] = 'tenant_query';
        $table_map['appointment'] = 'tenant_query';
        $table_map['lead_detail'] = 'tenant_custom_field';

        $type = (isset($table_map[$request['type']]))? $table_map[$request['type']] : 'tenant_custom_field';
        $param_rules['id']       = "required|exists:$type,id,tenant_id,".$request['company_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        $this->__is_collection = false;

        if($request['type'] == 'lead_detail')
            return $this->__sendResponse('TenantQuery', TenantCustomField::getById($id), 200,'Your lead has been added successfully.');

        return $this->__sendResponse('TenantQuery', TenantQuery::getById($id), 200,'Your lead has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editQueryDetails(Request $request, $id)
    {
        $this->__view = 'subadmin/questionnaire_edit';
        //$this->__is_redirect = true;

        $list['categories'] = Category::where(['company_id' => $request['company_id'], 'parent_id' => 0,'type' => 2])->with(['category_survey'])->get();

        $query = Query::find($id);

        $list['photo_views'] = Category::where(['parent_id' => $query['category_id']])->get(['id','name']);

        /** to be removed commented on Jan-2023 For tags mapped by questions (not in use now)  */
//        $queryIds = array_column($query->toArray(),'id');
//        $tags = Tag::whereIn('ref_id',$queryIds)->where(['ref_type' => 'query'])->get()->toArray();
//        $mQuery = Helper::mergeArrayWithElementValue($query->toArray(),'id',$tags,'ref_id','query_tags');

        if(!empty($query['options'])){
            $query['options']  = explode(',',$query['options']);
        }

        $list['query_id'] = $id;
        $list['query'] = $query;

//        dd($list);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Query', $list, 200,__('app.success_show_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuery(Request $request,$id)
    {
        $this->__view = 'subadmin/questionnaire?page='.$request['page'];
        $this->__is_ajax = true;
        $this->__collection = false;
        $request['query_id'] = $id;
        //<editor-fold desc="Validation">
        $param_rules['company_id']      = 'required';
        $param_rules['query_id']        = 'required|int';
        $param_rules['area']            = 'required|int';
        $param_rules['question']        = 'required|string';
        $param_rules['type']            = 'required';
        $param_rules['is_required']     = 'required|in:true,false';

        $param_rules['options.*']        = 'required_if:type,checkbox,radio|distinct';
        $param_rules['help_photo']       = 'nullable|mimes:jpg,jpeg,png,gif,pdf';
        $param_rules['photo_view']       = 'required_if:type,checkbox,radio';

        $customMessages['options.*.distinct'] = "The options have a duplicate value";
        $customMessages['photo_view.required_if'] = "Photo View field is required";


        $response = $this->__validateRequestParams($request->all(), $param_rules,$customMessages);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not updated Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        $updateResult = Query::updateQuery($request);

        if(!empty($updateResult['error'])){
            $this->__is_paginate = false;
            $this->__is_collection = false;
            return $this->__sendError($updateResult['error'], [], 400);
        }


        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Query', [], 200,'Your query has been updated successfully.');
    }


    public function deleteQuery(Request $request,$id){

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;
        $request['id'] = $id;
        //<editor-fold desc="Validation">
        $param_rules['id'] = 'required|int|';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Deleted Successfully', $error['data']);
            return $response;
        }
        //</editor-fold>
        $message = "Not Deleted Successfully";

        $pQ = ProjectQuery::where('query_id',$id)->exists();

        if($pQ){
            $message = title_case("Can't Delete. Question is filled in a project.");
            return $this->__sendError($message,[],400);
        }else{
            $result = Query::deleteQuery($id);
            /*QueryTag::deleteQueryTagByQueryId($id);*/

            if($result /*TRUE */){
                $message = "Deleted Successfully";
            }
        }

        return $this->__sendResponse('TenantQuery', ['message' => $message], 200,'Your questionnaire has been deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
    }

    public function editSelect(){
        return view('subadmin/select_area');
    }
    public function edit_questionnaire(){

        return view('subadmin/questionnaire_edit');
    }
    public function select_questionnaire_edit_area(){
        return view('subadmin/select_questionnaire_edit_area');
    }
}