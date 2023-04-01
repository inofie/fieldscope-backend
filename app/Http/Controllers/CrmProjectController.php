<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\JobScope;
use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyGroupCategory;
use App\Models\CrmModel;
use App\Models\NotificationIdentifier;
use App\Models\Project;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;


class CrmProjectController extends Controller
{

    function __construct()
    {
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes
        ini_set('max_execution_time', 0); // for infinite time of execution
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'store', 'detail', 'index', 'show','getEmployeeProject' ,'getSpecList'
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

        $param = $request->all();
        $param['paginate'] = TRUE;
        $list = Project::getList($param);

        $this->__is_paginate = true;
        $this->__is_collection = true;
        return $this->__sendResponse('Project', $list, 200, 'Project list retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request['assigned_user_id'] = !empty($request['assigned_user_id']) ? $request['assigned_user_id'] : $request['user_id'];
        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['address1'] = 'required|string|max:100';
        $param_rules['address2'] = 'nullable|string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
        $param_rules['user_id'] = 'required|int';
        $param_rules['state_id'] = 'required|int';
        $param_rules['city_id'] = 'required|int';
        $param_rules['postal_code'] = 'required|string|max:100';
        $param_rules['claim_num'] = 'nullable|string|max:100';
        $param_rules['inspection_date'] = 'required|date_format:Y-m-d';
        $param_rules['latitude'] = 'required|string|max:100';
        $param_rules['longitude'] = 'required|string|max:100';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;


        $project = new Project();
        $project->company_id = $request->company_id;
        $project->name = $request->name;
        $project->address1 = $request->address1;
        $project->address2 = $request->address2;
        $project->assigned_user_id = $request->assigned_user_id;
        $project->user_id = $request->user_id;
        $project->state_id = $request->state_id;
        $project->city_id = $request->city_id;
        $project->postal_code = $request->postal_code;
        $project->claim_num = $request->claim_num;
//        $project->inspection_date = date('Y-m-d ', strtotime($request->inspection_date));
        $project->inspection_date = $request->inspection_date;
        $project->latitude = $request->latitude;
        $project->longitude = $request->longitude;

        if (!$project->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

//        Helper::p($request->all());
        $users = User::where(['company_id' => $request->company_id, 'id' => $request['user_id']])->first()->toArray();
        $params = [
            'company_id' => $users['company_id'],
            'company_group_id' => $users['company_group_id'],
        ];

        //Helper::pd($params);
        $categories = CompanyGroupCategory::getCategories($params, TRUE);
//        print_r($categories->toArray());
//        die;


        $list = Project::getById($project->id);
        $list['categories'] = $categories;

        $country = Admin::getCountries(['id' => $project->country_id])->toArray();
        $state = Admin::getStates(['id' => $project->state_id])->toArray();
        $city = Admin::getCities(['id' => $project->city_id])->toArray();

        $list['country_name'] = $country[0]->name;
        $list['state_name'] = $state[0]->name;
        $list['city_name'] = $city[0]->name;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $list, 200, 'Project added successfully.');
    }



    public function projectDetail(Request $request)
    {

        $crm = new JobScope();
        $crm->authenticate();
        $crm->getProjectDetail();
        //$crm->getSpecFields();

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $crm->response['data'], 200, 'Project Crm detail retrieved successfully.');
    }

    public function projectCreate(Request $request)
    {

        $crm = new JobScope();
        $crm->authenticate();
        //$crm->getProjectDetail();
        $crm->createProject();

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $crm->response['data'], 200, 'Project Crm detail retrieved successfully.');
    }

    public function getEmployee(Request $request)
    {
        $crm = new JobScope();
//        $crm->authenticate();

        $email_address = 'sales.rep@emerson-enterprises.com';
        $crm->getEmployee($email_address);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $crm->response['data'], 200, 'Project Crm detail retrieved successfully.');
    }

    public function getEmployeeProject(Request $request)
    {
        $company = Company::getById($request['company_id']);
        if(empty($company->crm_employee_id) && !isset($company->crm_employee_id))
            return $this->__sendError('error', ['message' => 'CRM Not synced']);

        $crm = new JobScope();
        $crm->getEmployeeProject($company->crm_employee_id);

//        p($crm->response,'$crm');

        if (!empty($crm->response['data']) && $crm->response['code'] == 200) {
            /** Getting projects already bind to CRM projects */
            $projectM = new Project();
            $project = $projectM->select('id', 'crm_project_id')->whereIn('crm_project_id', array_column($crm->response['data'], 'id'))->get();

            /** Removing already binded crm projects */
            foreach ($crm->response['data'] AS $key => $item) {
                if(!empty($item['id'])){
                    if (in_array($item['id'], array_column($project->toArray(), 'crm_project_id'))) {
                        unset($crm->response['data'][$key]);
                    }
                }
            }
        }/*else{
            return $this->__sendError('error', ['message' => $crm->response['data']->message]);
        }*/

        if(isset($crm->response['data']['message']))
            return $this->__sendError('error', ['message' => $crm->response['data']['message'] ]);

        $this->__is_paginate = false;
        $this->__is_custom_collection = true;
        return $this->__sendResponse('CrmProject', $crm->response['data'], 200, 'Project Crm detail retrieved successfully.');
    }

    public function getSpecList(Request $request)
    {
        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;

        $company = Company::getById($request['company_id']);
//        Helper::pd($company->toArray() ,'$company');
        if (empty($company->crm_employee_id) && !isset($company->crm_employee_id))
            return $this->__sendError('error', ['message' => 'CRM Not synced']);

        $specType = [
            'Roofing Specs',
            'Gutter Specs',
            'Siding Specs',
            'Garage Door Specs',
            'Insulation Specs',
            'Roofing Specs',
            'Gutter Specs',
            'Siding Specs',
            'Garage Door Specs',
            'Insulation Specs'
        ];

        $crm = new JobScope();

        $key = array_search($request['id'],$specType);
        $crm->getSpecs($specType[$key]);
//        pd($crm->response['data'],'$crm->response');
//        $crm->getEmployeeProject('857e3102-792f-42e1-960b-3a0a041fd775');

        if(isset($crm->response['data']['message']))
            return $this->__sendError('error', ['message' => $crm->response['data']->message]);


        return $this->__sendResponse('CrmProject', $crm->response['data'], 200, 'Project Crm detail retrieved successfully.');
    }

    public function getProject(Request $request){

        $projectM = new Project();
        $project = $projectM->getCrmProject(103);

        $crm = new JobScope();
        $crm->addProject($project);
    }

    public function getCrmMedia(Request $request)
    {
        $projectM = new Project();
        $projectMedia = $projectM->getCrmProjectMedia(103);
        $crm = new JobScope();
        $crm->addMedia($projectMedia);
    }

    public function syncProject(Request $request)
    {
        $this->__view = 'subadmin/project';
        $this->__is_redirect = true;

        $projectM = new Project();
        $unSyncedProjects = $projectM->getCRM_notSyncedProject(2);
        $projectsForCrm = $projectM->getCrmProjects($unSyncedProjects->toArray());
        $crmParsedProjects = CrmModel::parseProjectSpecs($projectsForCrm);

        if(!empty($crmParsedProjects)){
            $crm = new JobScope();
            if($crm->response['code'] == 400){
                $this->__setFlash('danger', 'Unable To Connect To JobScope');
                return $this->__sendError('cURL ERROR');
            }
            $crmProjectResponse = $crm->addProject($crmParsedProjects);

            if(!empty($crmProjectResponse['error'])){
                $pErrorIDs = array_column($crmProjectResponse['error'],'id');
                Log::error('ERROR - Unable sync project.',$crmProjectResponse['error']);
                $this->__setFlash('danger', 'Unable To Sync Project.');
            }

            /** Projects that are success updating and handling */
            if(!empty($crmProjectResponse['success'])){
                $pSuccessIDs = array_column($crmProjectResponse['success'],'id');
                Log::info('SUCCESS - Project posted to CRM.',$crmProjectResponse['success']);
                if($projectM->syncedProjects($pSuccessIDs) < 1){
                    $this->__sendError('success', 'Unable To Update Synced Project');
                }
                $this->__setFlash('success', 'Syncing Completed.');
            }
        } else {
            Log::info('INFO: No un-synced projects');
            $this->__setFlash('info', 'No Project To Sync.');
        }

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Project',$crmParsedProjects,200,'Project Synced');
    }
}

