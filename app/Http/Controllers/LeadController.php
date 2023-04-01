<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Models\Lead;
use App\Models\LeadCustomField;
use App\Models\LeadHistory;
use App\Models\Media;
use App\Models\LeadQuery;
use App\Models\Status;
use App\Models\TenantCustomField;
use App\Models\Type;
use App\Models\User;
use App\Models\UserLeadAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LeadController extends Controller
{

    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => ['index', 'store', 'update', 'edit', 'show', 'userAssignLead', 'userList'
            , 'history', 'updateQuery', 'createAppointment', 'createOutBoundAppointment', 'leadReport', 'indexView', 'addView', 'listView'
            , 'uploadMedia', 'leadStatsReport', 'bulkUpdate'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param_rules['search'] = 'sometimes';

        $time_slot_map['today'] = 'INTERVAL 1 MONTH';
        $time_slot_map['yesterday'] = 'INTERVAL 1 MONTH';
        $time_slot_map['week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['year'] = 'INTERVAL 1 YEAR';
        $time_slot_map['last_year'] = 'INTERVAL 1 YEAR';

        $param['search'] = isset($request['search']) ? $request['search'] : '';
        $param['latitude'] = isset($request['latitude']) ? $request['latitude'] : '';
        $param['longitude'] = isset($request['longitude']) ? $request['longitude'] : '';
        $param['lead_type_id'] = isset($request['lead_type_id']) ? $request['lead_type_id'] : '';
        $param['user_ids'] = isset($request['target_user_id']) ? trim($request['target_user_id']) : '';
        $param['status_ids'] = isset($request['status_id']) ? trim($request['status_id']) : '';
        $param['radius'] = isset($request['radius']) ? $request['radius'] : 500;
        $param['time_slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $time_slot_map[$request['time_slot']] : '' : '';
        $param['slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $request['time_slot'] : '' : '';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_ids'] = empty($param['user_ids']) ? [] : explode(',',$param['user_ids']);
        $param['status_ids'] = empty($param['status_ids']) ? [] : explode(',',$param['status_ids']);

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];

        $response = Lead::getList($param);

        return $this->__sendResponse('Lead', $response, 200, 'Lead list retrieved successfully.');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView(Request $request){

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['is_paginate'] = false;

        $response['status'] = Status::getList($param);

        $status_count = 0;
        $status_total = 0;
        foreach ($response['status'] as $key => $status){
            $status_count++;
            $status_total += $status['lead_count'];
        }

        if($status_total) {
            foreach ($response['status'] as $key => $status) {
                $response['status'][$key]['lead_percentage'] = round((($status['lead_count'] / $status_total) * 100),1);
            }
        }



        $response['agent'] = User::getTenantUserList($param);
        $response['type'] = Type::whereIn('tenant_id', [$request['company_id']])->whereNull('deleted_at')->get();

        $response['columns'] = ['title','address', 'city', 'zip_code'];
        $custom_fields =TenantCustomField::getList($param);
        foreach($custom_fields as $field)
            $response['columns'][] = $field['key'];



        $this->__view = 'tenant.lead.lead_mgmt';

        $this->__is_paginate = false;
        $this->__collection = false;
        $this->__is_collection = false;

        return $this->__sendResponse('lead', $response, 200, 'Lead list retrieved successfully.');

    }

    public function listView(Request $request)
    {
        $param_rules['search'] = 'sometimes';

        $param['search'] = isset($request['search']) ? $request['search'] : '';
        $param['latitude'] = isset($request['latitude']) ? $request['latitude'] : '';
        $param['longitude'] = isset($request['longitude']) ? $request['longitude'] : '';
        $param['radius'] = isset($request['radius']) ? $request['radius'] : 500;
        $param['user_ids'] = isset($request['user_ids']) ? trim($request['user_ids']) : '';
        $param['status_ids'] = isset($request['status_ids']) ? trim($request['status_ids']) : '';
        $param['start_date'] = isset($request['start_date']) ? $request['start_date'] : '';
        $param['end_date'] = isset($request['end_date']) ? $request['end_date'] : '';

        // status list , with count of leads, percentage of total leads

        // search on created at date range


        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['user_ids'] = empty($param['user_ids']) ? [] : explode(',',$param['user_ids']);
        $param['status_ids'] = empty($param['status_ids']) ? [] : explode(',',$param['status_ids']);

        $response= \App\Http\Resources\Lead::collection(Lead::getList($param));
        //$response['status'] = \App\Http\Resources\Status::collection(Status::getList($param));

        /*$status_count = 0;
        $status_total = 0;
        foreach ($response['status'] as $key => $status){
            if(!in_array($status['id'], $param['status_ids']) && !empty($param['status_ids'])) {
                $response['status'][$key]['lead_count'] = 0;
                continue;
            }

            $status_count++;
            $status_total += $status['lead_count'];
        }

        if($status_total) {
            foreach ($response['status'] as $key => $status) {

                if (!in_array($status['id'], $param['status_ids']) && !empty($param['status_ids'])) {
                    $response['status'][$key]['lead_percentage'] = 0;
                    continue;
                }
                $response['status'][$key]['lead_percentage'] = round((($status['lead_count'] / $status_total) * 100),1);
            }
        }*/

        $this->__collection = false;
        return $this->__sendResponse('Lead', $response, 200, 'Lead list retrieved successfully.');

    }

    public function statusListView(Request $request)
    {
        $param_rules['search'] = 'sometimes';

        $param['status_ids'] = isset($request['status_ids']) ? trim($request['status_ids']) : '';

        // status list , with count of leads, percentage of total leads

        // search on created at date range


        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['user_ids'] = empty($param['user_ids']) ? [] : explode(',',$param['user_ids']);
        $param['status_ids'] = empty($param['status_ids']) ? [] : explode(',',$param['status_ids']);

        $response = \App\Http\Resources\Status::collection(Status::getList($param));

        $status_count = 0;
        $status_total = 0;
        foreach ($response as $key => $status){
            if(!in_array($status['id'], $param['status_ids']) && !empty($param['status_ids'])) {
                $response[$key]['lead_count'] = 0;
                continue;
            }

            $status_count++;
            $status_total += $status['lead_count'];
        }

        if($status_total) {
            foreach ($response as $key => $status) {

                if (!in_array($status['id'], $param['status_ids']) && !empty($param['status_ids'])) {
                    $response[$key]['lead_percentage'] = 0;
                    continue;
                }
                $response[$key]['lead_percentage'] = round((($status['lead_count'] / $status_total) * 100),1);
            }
        }
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', $response, 200, 'Lead list retrieved successfully.');

    }

    public function addView(Request $request)
    {
        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['is_paginate'] = false;

        $response['status'] = Status::whereIn('tenant_id', [$request['company_id']])->whereNull('deleted_at')->get();
        $response['type'] = Type::whereIn('tenant_id', [$request['company_id']])->whereNull('deleted_at')->get();
        $response['custom_fields'] =TenantCustomField::getList($param);

        $this->__view = 'tenant.lead.add_lead';
        $this->__is_paginate = false;
        $this->__is_collection = false;

        return $this->__sendResponse('Lead', $response, 200, 'Lead list retrieved successfully.');
    }

    public function userList(Request $request)
    {
        $param_rules['search'] = 'sometimes';

        $time_slot_map['today'] = 'INTERVAL 1 MONTH';
        $time_slot_map['yesterday'] = 'INTERVAL 1 MONTH';
        $time_slot_map['week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['year'] = 'INTERVAL 1 YEAR';
        $time_slot_map['last_year'] = 'INTERVAL 1 YEAR';

        $param['search'] = isset($request['search']) ? $request['search'] : '';
        $param['latitude'] = isset($request['latitude']) ? $request['latitude'] : '';
        $param['longitude'] = isset($request['longitude']) ? $request['longitude'] : '';
        $param['lead_type_id'] = isset($request['lead_type_id']) ? $request['lead_type_id'] : '';
        $param['user_ids'] = isset($request['target_user_id']) ? trim($request['target_user_id']) : '';
        $param['status_ids'] = isset($request['status_id']) ? trim($request['status_id']) : '';
        $param['radius'] = isset($request['radius']) ? $request['radius'] : 500;
        $param['time_slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $time_slot_map[$request['time_slot']] : '' : '';
        $param['slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $request['time_slot'] : '' : '';


        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];

        $response = Lead::getUserList($param);

        return $this->__sendResponse('Lead', $response, 200, 'Assigned lead list retrieved successfully.');

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
    public function store(Request $request)
    {
        $param_rules['user_id'] = 'required';
        $param_rules['title'] = 'required';
        $param_rules['address'] = 'required';
        $param_rules['type_id'] = 'required';
        $param_rules['status_id'] = 'required';
        $param_rules['image_url']  = 'required';
        $param_rules['image_url.*'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        //$param_rules['latitude']  = 'required';
        //$param_rules['longitude']  = 'required';
        $this->__is_ajax = true;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $system_image_url = [];
        if ($request->hasFile('image_url')) {
            foreach ($request->image_url as $image_url) {
                // $obj is model
                $system_image_url[] = $this->__moveUploadFile(
                    $image_url,
                    md5($request->title . time().rand(10,99)),
                    Config::get('constants.MEDIA_IMAGE_PATH')
                );
            }
        }

        $lat_long_response = $this->getLatLongFromAddress($request->address);

        $obj = new Lead();
        $obj->creator_id = $request->user_id;
        $obj->company_id = $request->company_id;
        $obj->title = $request->title;
        $obj->address = $request->address;

        $obj->type_id = $request->type_id;
        $obj->status_id = $request->status_id;

        $obj->latitude = $lat_long_response['lat'];
        $obj->longitude = $lat_long_response['long'];
        $obj->formatted_address = $lat_long_response['formatted_address'];
        $obj->city = $lat_long_response['city'];
        $obj->zip_code = $lat_long_response['zip_code'];

        $obj->save();

        Media::createBulk($obj->id, 'lead', 'image', $system_image_url);

        // insert lead queries
        LeadQuery::insertBulk($obj->id, $request->company_id);
        // dump status on tenant creation, get first status id of tenant and pass to lead count
        //$status_id = Status::getFirstTenantStatus($request->company_id);
        $status_id = $request->status_id;
        Status::incrementLeadCount($status_id);

        $obj_lead_history = new LeadHistory();

        $obj_lead_history->lead_id = $obj->id;
        $obj_lead_history->assign_id = $request['user_id'];
        $obj_lead_history->status_id = $status_id;
        $obj_lead_history->save();

        // insert lead custom fields
        $ignore_fields = ['_token', 'user_id', 'company_id', 'title', 'address', 'type_id', 'status_id', 'image_url'];
        LeadCustomField::insert($obj->id, $ignore_fields, $request->all());

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($obj->id), 200,'Your lead has been added successfully.');
    }

    public function wizardView(Request $request){

        $response['template'] =Lead::getTemplate($request['company_id']);
        $response['fields'] = TenantCustomField::getList(['company_id' => $request['company_id']]);


        $this->__view = 'tenant.lead.wizard';
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Wizard', $response, 200,'Your leads file has been added in process.');

    }

    public function uploadLeads(Request $request)
    {
        $param_rules['user_id'] = 'required';
        $param_rules['file']  = 'required|mimes:xlsx|max:2048';

        $this->__is_ajax = true;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $system_image_url = [];
        if ($request->hasFile('file')) {
            // $obj is model
            $system_file_url = $this->__moveUploadFile(
                $request->file,
                md5($request['company_id']),
                Config::get('constants.MEDIA_FILE_PATH'),
                false
            );
        }

        $param['tenant_id'] = $request['company_id'];
        $param['media_url'] = $system_file_url;
        Lead::saveTempFile($param);


        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', [], 200,'Your leads file has been added in process.');
    }

    public function uploadMedia(Request $request, $lead_id)
    {
        $param_rules['user_id'] = 'required';
        $param_rules['lead_id']  = 'required|exists:lead,id';
        $param_rules['image_url']  = 'required';
        $param_rules['image_url.*'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        $request['lead_id'] = $lead_id;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $system_image_url = [];
        $system_image_url = [];
        if ($request->hasFile('image_url')) {
            foreach ($request->image_url as $image_url) {
                // $obj is model
                $system_image_url[] = $this->__moveUploadFile(
                    $image_url,
                    md5($lead_id . time().rand(10,99)),
                    Config::get('constants.MEDIA_IMAGE_PATH')
                );
            }
        }

        Media::deleteBySourceId($lead_id);
        Media::createBulk($lead_id, 'lead', 'image', $system_image_url);


        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($lead_id), 200,'Your leads media has been updated sucessfully.');
    }

    public function wizardTemplate(Request $request)
    {
        $param_rules['user_id'] = 'required';

        $this->__is_ajax = true;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;
        $response['template_id'] = 0;
        if(isset( $request['template_id']) && !empty( $request['template_id']))
            $response['template_id'] = $request['template_id'];

        if(!isset( $request['template_id']) || empty( $request['template_id'])) {
            $param['tenant_id'] = $request['company_id'];
            $param['title'] = $request['template'];
            $param['description'] = $request['template'];
            $response['template_id'] = Lead::saveTemplate($param);
        }

        $response['fields'] = TenantCustomField::getList(['company_id' => $request['company_id']]);
        $temp_file =Lead::getTempfile($request['company_id']);

        $response['file_header'] = $this->__getFileContent(storage_path(Config::get('constants.MEDIA_FILE_PATH').$temp_file->media_url), 1);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Template', $response, 200,'Your lead template has been created successfully.');
    }

    public function wizardFields(Request $request)
    {
        $param_rules['user_id']     = 'required';
        $param_rules['template_id'] = 'required';
        $param_rules['lead_name']   = 'required';
        $param_rules['lead_type']   = 'required';
        $param_rules['address']     = 'required';
        $param_rules['city']        = 'required';
        $param_rules['zip_code']    = 'required';

        $this->__is_ajax = true;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $status_id = Status::getFirstTenantStatus($request->company_id);

        $lead_types = [];
        $lead_type_result = Type::whereIn('tenant_id', [$request['company_id']])->whereNull('deleted_at')->get();
        $lead_type_id = 0;
        $count = 0;
        foreach($lead_type_result as $lead_type) {
            if($count == 0)
                $lead_type_id = $lead_type->id;
            $lead_types[strtolower($lead_type->title)] = $lead_type->id;
            $count++;
        }


        $temp_file =Lead::getTempfile($request['company_id']);
        $file_leads = $this->__getFileContent(storage_path(Config::get('constants.MEDIA_FILE_PATH').$temp_file->media_url));

        // get file name
        // insert bulk lead
        // insert bulk custom field
        // insert template fields
        $temp_fields = [];

        for($i = 1; $i<=count($file_leads); $i++) {
            if(empty($request->address) || !isset($file_leads[$i]))
                continue;

            $lat_long_response = $this->getLatLongFromAddress($request->address);

            $obj = new Lead();
            $obj->creator_id = $request->user_id;
            $obj->company_id = $request->company_id;
            $obj->title = $file_leads[$i][$request['lead_name']];
            $obj->address = $file_leads[$i][$request['address']];

            $obj->type_id = (isset($lead_types[$file_leads[$i][$request['lead_type']]]))? $lead_types[$file_leads[$i][$request['lead_type']]] : $lead_type_id;
            $obj->status_id = $status_id;

            $obj->latitude = $lat_long_response['lat'];
            $obj->longitude = $lat_long_response['long'];
            $obj->formatted_address = $lat_long_response['formatted_address'];
            $obj->city = (!empty($file_leads[$i][$request['city']]))? $file_leads[$i][$request['city']]: $lat_long_response['city'];
            $obj->zip_code = (!empty($file_leads[$i][$request['zip_code']]))? $file_leads[$i][$request['zip_code']]: $lat_long_response['zip_code'];

            $obj->save();
            $temp_fields['lead_name'] = $request['lead_name'];
            $temp_fields['address'] = $request['address'];
            $temp_fields['lead_type'] = $request['lead_type'];
            $temp_fields['city'] = $request['city'];
            $temp_fields['zip_code'] = $request['zip_code'];

            // insert lead queries
            LeadQuery::insertBulk($obj->id, $request->company_id);

            // dump status on tenant creation, get first status id of tenant and pass to lead count
            Status::incrementLeadCount($status_id);

            $obj_lead_history = new LeadHistory();

            $obj_lead_history->lead_id = $obj->id;
            $obj_lead_history->assign_id = $request['user_id'];
            $obj_lead_history->status_id = $status_id;
            $obj_lead_history->save();

            // insert lead custom fields
            $custom_fields = [];
            $ignore_fields = ['company_id'];
            $custom_fields['company_id'] = $request->company_id;
            foreach($request['custom_field'] as $key => $value) {
                if(!empty($file_leads[$i][$value]) && strtolower($value) != 'n/a') {
                    $custom_fields[$key] = $file_leads[$i][$value];
                    $temp_fields[$key] = $value;
                }
            }
            LeadCustomField::insert($obj->id, $ignore_fields, $custom_fields);
        }
        if(count(((array) $temp_fields))){
            Lead::saveTemplateFields($request['template_id'], $temp_fields);
        }
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', [], 200,'Your lead bulk has been added successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $param_rules['id'] = 'required|exists:lead,id';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($id), 200,'Lead has been retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $param_rules['id'] = 'required|exists:lead,id';
        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['is_paginate'] = false;

        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;

        $response['status'] = Status::getList($param);
        $response['agent'] = User::getTenantUserList($param);
        $response['type'] = Type::whereIn('tenant_id', [$request['company_id']])->whereNull('deleted_at')->get();
        $response['lead'] = Lead::getById($id);

        $this->__view = 'tenant.lead.lead_detail';

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', $response, 200,'Lead has been retrieved successfully.');

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
        $request['id'] = $id;
        $param_rules['id'] = 'required|exists:lead,id';
        $param_rules['target_id'] = 'required|exists:user,id';
        $param_rules['status_id'] = 'required|exists:status,id';
        $param_rules['title'] = 'required';
        $param_rules['type_id'] = 'required';
        $param_rules['address'] = 'required';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_lead = Lead::find($id);
        $status_id = $obj_lead->status_id;
        $address = $obj_lead->address;
        $obj_lead->title = $request['title'];
        $obj_lead->assignee_id = $request['target_id'];
        $obj_lead->status_id = $request['status_id'];
        $obj_lead->type_id = $request['type_id'];

        if($address != $obj_lead->address){
            $lat_long_response = $this->getLatLongFromAddress($request->address);

            $obj_lead->latitude = $lat_long_response['lat'];
            $obj_lead->longitude = $lat_long_response['long'];
            $obj_lead->formatted_address = $lat_long_response['formatted_address'];
            $obj_lead->city = $lat_long_response['city'];
            $obj_lead->zip_code = $lat_long_response['zip_code'];
        }

        $obj_lead->save();

        if($status_id != $request['status_id']) {
            $obj_lead_history = new LeadHistory();

            $obj_lead_history->lead_id = $id;
            $obj_lead_history->assign_id = $request['target_id'];
            $obj_lead_history->status_id = $obj_lead->status_id;
            $obj_lead_history->save();

            Status::incrementLeadCount($obj_lead->status_id);
            Status::decrementLeadCount($status_id);
        }

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($id), 200,'Lead has been retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulkUpdate(Request $request)
    {
        $param_rules['assign_id'] = 'nullable|exists:user,id';
        $param_rules['status_id'] = 'nullable|exists:status,id';
        $param_rules['type_id'] = 'nullable|exists:type,id';
        $param_rules['action'] = 'required|in:delete,update';
        $param_rules['lead_ids'] = 'required';

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $params['assign_id'] = (isset($request['assign_id']))? $request['assign_id'] : '';
        $params['status_id'] =  (isset($request['status_id']))? $request['status_id'] : '';
        $params['type_id'] =  (isset($request['type_id']))? $request['type_id'] : '';
        $params['action'] = $request['action'];
        $params['lead_ids'] = $request['lead_ids'];
        $params['company_id'] = $request['company_id'];
        $params['target_user_id'] = (!empty($request['assign_id']))? $request['assign_id'] : $request['user_id'];

        Lead::bulkUpdate($params);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', [], 200,'Lead has been updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuery(Request $request, $id)
    {
        $request['id'] = $id;
        $param_rules['id'] = 'required|exists:lead,id';
        $param_rules['status_id'] = 'required|exists:status,id';
        $param_rules['query'] = 'required';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_lead = Lead::find($id);
        $status_id = $obj_lead->status_id;
        $obj_lead->assignee_id = $request['user_id'];
        $obj_lead->status_id = $request['status_id'];
        $obj_lead->save();

        if($status_id != $request['status_id']) {
            $obj_lead_history = new LeadHistory();

            $obj_lead_history->lead_id = $id;
            $obj_lead_history->assign_id = $request['user_id'];
            $obj_lead_history->status_id = $obj_lead->status_id;
            $obj_lead_history->save();

            Status::incrementLeadCount($obj_lead->status_id);
            Status::decrementLeadCount($status_id);
        }
        LeadQuery::updateQuery($id, json_decode($request['query'],true));

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($id), 200,'Lead has been retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userAssignLead(Request $request, $lead_id)
    {
        $param_rules['id'] = 'required|exists:lead,id';
        $param_rules['target_id'] = 'required|exists:user,id';

        $request['id'] = $lead_id;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_lead = Lead::find($lead_id);
        $obj_lead->assignee_id = isset($request['target_id'])? $request['target_id'] : $request['user_id'];
        $obj_lead->save();

        /*$obj_lead_history = new LeadHistory();

        $obj_lead_history->lead_id   = $lead_id;
        $obj_lead_history->assign_id = $request['user_id'];
        $obj_lead_history->status_id = $obj_lead->status_id;
        $obj_lead_history->save();*/

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($lead_id), 200,'Lead has been retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {

        $param_rules['search'] = 'sometimes';
        $param_rules['lead_id'] = 'sometimes';

        $param['search'] = isset($request['search']) ? $request['search'] : '';
        $param['lead_id'] = isset($request['lead_id']) ? $request['lead_id'] : '';
        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];

        $response = LeadHistory::getList($param);

        return $this->__sendResponse('LeadHistory', $response, 200, 'Lead history list retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createAppointment(Request $request)
    {
        $param_rules['lead_id'] = 'required|exists:lead,id';
        $param_rules['query'] = 'required';
        $param_rules['appointment_date'] = 'required|date_format:"Y-n-j G:i"|after_or_equal:' . date("Y-n-j G:i");

        $appointment_date = explode(':', $request['appointment_date']);
        $appointment_date_min = (isset($appointment_date[1])) ? ((strlen($appointment_date[1]) > 1) ? $appointment_date[1] : "0{$appointment_date[1]}") : '00';
        $request['appointment_date'] = "{$appointment_date[0]}:$appointment_date_min";

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $appointments = UserLeadAppointment::whereRaw("('{$request['appointment_date']}:00'" . ' between `appointment_date` and `appointment_end_date`)')
                            ->where('user_id', $request['user_id'])
                            ->count();

        if(!empty($appointments)){
            $errors['appointment_date'] = 'Appointment is already Scheduled';
            return $this->__sendError('Validation Error.', $errors);
        }

        $obj_appointment = new UserLeadAppointment();
        $obj_appointment->lead_id = $request['lead_id'];
        $obj_appointment->user_id = $request['user_id'];
        $obj_appointment->appointment_date = $request['appointment_date'];
        $obj_appointment->appointment_end_date = $request['appointment_date'];
        $obj_appointment->is_out_bound = 0;
        $obj_appointment->type = 'lead';
        $obj_appointment->save();

        $obj_lead = Lead::find($request['lead_id']);
        $obj_lead->assignee_id = $request['user_id'];
        $obj_lead->appointment_date = $request['appointment_date'];
        $obj_lead->save();

        LeadQuery::updateQuery($request['lead_id'], json_decode($request['query'], true));


        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($request['lead_id']), 200, 'Appointment Lead has been created successfully.');
    }

    public function createOutBoundAppointment(Request $request)
    {
        $param_rules['start_date'] = 'required|date_format:"Y-n-j G:i"|after_or_equal:' . date("Y-n-j G:i");
        $param_rules['end_date'] = 'required|date_format:"Y-n-j G:i"|after:' . $request['start_date']; //date("Y-n-j G:i");
        $param_rules['result'] = 'nullable';

        $appointment_date = explode(':', $request['start_date']);
        $appointment_date_min = (isset($appointment_date[1])) ? ((strlen($appointment_date[1]) > 1)? $appointment_date[1] : "0{$appointment_date[1]}") : '00';
        $request['start_date'] = "{$appointment_date[0]}:$appointment_date_min";

        $appointment_date = explode(':', $request['end_date']);
        $appointment_date_min = (isset($appointment_date[1])) ? ((strlen($appointment_date[1]) > 1)? $appointment_date[1] : "0{$appointment_date[1]}") : '00';
        $request['end_date'] = "{$appointment_date[0]}:$appointment_date_min";

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $obj_appointment = new UserLeadAppointment();
        $obj_appointment->lead_id = 0;
        $obj_appointment->user_id = $request['user_id'];
        $obj_appointment->appointment_date = $request['start_date'];
        $obj_appointment->appointment_end_date = $request['end_date'];
        $obj_appointment->result = isset($request['result'])? $request['result'] : '';
        $obj_appointment->is_out_bound = 1;
        $obj_appointment->type = 'lead';
        $obj_appointment->save();

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('appointment', [], 200,'Outbound appointment has been created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function executeAppointment(Request $request)
    {
        $param_rules['lead_id'] = 'required|exists:lead,id';
        $param_rules['appointment_id'] = 'required|exists:user_lead_appointment,id';
        $param_rules['result'] = 'required';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];

        $obj_lead = Lead::find($request['lead_id']);
        $obj_lead->assignee_id = $request['user_id'];
        $obj_lead->appointment_result = $request['result'];
        $obj_lead->save();

        $obj_lead = UserLeadAppointment::find($request['appointment_id']);
        $obj_lead->result = $request['result'];
        $obj_lead->save();

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($request['lead_id']), 200,'Lead has been retrieved successfully.');
    }

    public function viewLeadReport(Request $request){

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['is_paginate'] = false;


        $response['status'] = Status::getList($param);
        $response['agent'] = User::getTenantUserList($param);

        $this->__view = 'tenant.team-performance.team-report';

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', $response, 200,'Lead has been retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leadReport(Request $request)
    {
        $time_slot_map['today'] = 'INTERVAL 1 MONTH';
        $time_slot_map['yesterday'] = 'INTERVAL 1 MONTH';
        $time_slot_map['week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_month'] = 'INTERVAL 1 MONTH';
        //$time_slot_map['bi_month'] = 'INTERVAL 15 DAY';
        //$time_slot_map['bi_year'] = 'INTERVAL 6 MONTH';
        $time_slot_map['year'] = 'INTERVAL 1 YEAR';
        $time_slot_map['last_year'] = 'INTERVAL 1 YEAR';

        $param['company_id'] = $request['company_id'];
        $param['time_slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $time_slot_map[$request['time_slot']] : $time_slot_map['month'] : $time_slot_map['month'];
        $param['slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $request['time_slot'] : 'month' : 'month';
        $param['user_id'] = isset($request['target_user_id']) ? $request['target_user_id'] : '';
        $param['status_id'] = isset($request['status_id']) ? $request['status_id'] : '';
        $param['lead_type_id'] = isset($request['lead_type_id']) ? $request['lead_type_id'] : '';
        $param['is_web'] = (strtolower($this->call_mode) == 'api') ? 0 : 1;


        $this->__is_ajax = true;
        $list = Lead::getStatusReport($param);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('UserCommission', $list, 200,'User commission list retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leadStatsReport(Request $request)
    {
        $time_slot_map['today'] = 'INTERVAL 1 MONTH';
        $time_slot_map['yesterday'] = 'INTERVAL 1 MONTH';
        $time_slot_map['week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_week'] = 'INTERVAL 1 MONTH';
        $time_slot_map['month'] = 'INTERVAL 1 MONTH';
        $time_slot_map['last_month'] = 'INTERVAL 1 MONTH';
        //$time_slot_map['bi_month'] = 'INTERVAL 15 DAY';
        //$time_slot_map['bi_year'] = 'INTERVAL 6 MONTH';
        $time_slot_map['year'] = 'INTERVAL 1 YEAR';
        $time_slot_map['last_year'] = 'INTERVAL 1 YEAR';

        $param['company_id'] = $request['company_id'];
        $param['time_slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $time_slot_map[$request['time_slot']] : $time_slot_map['month'] : $time_slot_map['month'];
        $param['slot'] = isset($request['time_slot']) ? (isset($time_slot_map[$request['time_slot']])) ? $request['time_slot'] : 'month' : 'month';
        $param['user_id'] = isset($request['target_user_id']) ? $request['target_user_id'] : '';
        $param['status_id'] = isset($request['status_id']) ? $request['status_id'] : '';
        $param['lead_type_id'] = isset($request['lead_type_id']) ? $request['lead_type_id'] : '';
        $param['is_web'] = (strtolower($this->call_mode) == 'api') ? 0 : 1;


        $this->__is_ajax = true;
        $list = Lead::getStatsReport($param);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('UserCommission', $list, 200,'User commission list retrieved successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $param_rules['id']       = 'required|exists:lead,id,company_id,'.$request['company_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['id' => $id], $param_rules);

        if($this->__is_error == true)
            return $response;

        Lead::destroy($id);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Lead', [], 200,'Lead has been deleted successfully.');
    }

}
