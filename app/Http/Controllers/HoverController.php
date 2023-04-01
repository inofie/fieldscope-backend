<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Hover;
use App\Models\Company;
use App\Models\CrmModel;
use App\Models\HoverField;
use App\Models\HoverJob;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HoverController extends Controller
{
    private $_company;

    function __construct(Request $request)
    {
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes
        ini_set('max_execution_time', 0); // for infinite time of execution
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'index', 'getRedirectUri','setHoverDetails' ,'createJob' ,'getMeasurements' ,'getSampleMeasurements' ,'jobTestUpdate']
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

    public function fieldList(Request $request, $id)
    {
        $hoverFields = HoverField::where(['hover_type_id' => $id])->get();

        $this->__collection = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', $hoverFields, '200', __('app.success_listing_message'));
    }

    public function getRedirectUri(Request $request){

        $ref_code = Company::getUniqueHoverRefCode();

        $updateRes = Company::where(['id' => $request->company_id])->update(['hover_ref_code' => $ref_code]);

        $this->__is_redirect = true;
        $this->__view = 'subadmin/settings';
        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }

    public function setAuthCode(Request $request,$code){

        Log::info("Hover Log: @setAuthCode: ".json_encode($request->all()));

        $this->__view = 'web/hover';

        $data = [];
        $upRes = Company::where(['hover_ref_code' => $code])->update(['hover_auth_code' => $request['code']]);

        if($upRes){
            $data['message'] = "Your Hover authorization code is set.";
        }else{
            $data['message'] = "Sorry! We're unable to set Hover authorization code.";
        }

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $data, 200, 'User list retrieved successfully.');
    }

    public function setHoverDetails(Request $request){

        $this->__view = 'subadmin/settings';
        $this->__is_redirect = true;

        $upRes = Company::where(['id' => $request['company_id']])->update(['hover_client_id' => $request['client_id'], 'hover_client_secret' => $request['client_secret'],]);

        CrmModel::where(['identifier' => 'hover', 'company_id' => $request['company_id']])->update([
            'access_token'=> "",
            'refresh_token'=> "",
            'token_type'=> "",
            'expires_at'=> "",
        ]);


        $this->__setFlash('danger', "Sorry! We're unable to set your hover details.");

        if($upRes){
            $this->__setFlash('success', "Hurray! Your hover is all set.");
        }

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, __(''));
    }

    public function createJob(Request $request){

        //<editor-fold desc="Validation">
        $param_rules['customer_name'] = "required";
        $param_rules['customer_email'] = "required";
        $param_rules['name'] = "required";
        $param_rules['location_line_1'] = "required";
        $param_rules['location_city'] = "required";
        $param_rules['location_region'] = "required";
        $param_rules['location_postal_code'] = "required";
        $param_rules['location_country'] = "required";
        $param_rules['project_ref_id'] = "required";

        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error){
            return $response;
        }
        //</editor-fold>

        $this->__is_collection = false;
        $this->__collection = false;
        $this->__is_paginate = false;

        $company = Company::getById($request['company_id']);
        $currentUser    = User::getById($request['user_id']);
        $hover = new Hover($company);
        $hoverJ = HoverJob::where(['project_ref_id' => $request['project_ref_id']])->first();

//        v($request['user_id'],'$res');
//        p($currentUser->toArray(),'$res');

        //<editor-fold desc="User isn't on hover > get all hover users and update">
        if(empty($currentUser['hover_user_id'])){

            $hUsers= $hover->listUsers();

            if(!empty($hUsers['results'])){
                $emails = array_pluck($hUsers['results'],'email');
                User::updateHoverUsers($hUsers,$request->all());

                if (!in_array($currentUser['email'], $emails)) { /** Checking if current user email is present in hover user email list*/
                    return $this->__sendError('Hover Error', ['error' => "Your company hasn't added you on hover"],400);
                }
            }
        }
        //</editor-fold>

        if (empty($company->hover_client_id) AND empty($company->hover_client_secret)) {
            return $this->__sendError('Hover Error', ['error' => "Your company hasn't been registered on hover"],400);
        } else if (!empty($hoverJ)) {
            return $this->__sendResponse('Project', [], 200, 'Job already created for project.');
        } else {

            $request['current_user_email'] = $currentUser['email'];
            $response = $hover->createJob($request->all());

            if(empty($response['job']['id'])){
                return $this->__sendError('Hover Error', ['error' => "Unable to create a job on hover."],400);
            }
            $hover->updateTestJob($response['job']['id'],'complete',$currentUser['email']);
            $res = HoverJob::firstOrCreate(['project_ref_id' => $request['project_ref_id'] ],['job_id' => $response['job']['id'] , 'company_id' => $request['company_id']]);
        }

        $this->__is_collection = false;
        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Project', ['job_id' => $response['job']['id']], 200, __('app.success_store_message'));
    }

    public function jobTestUpdate(Request $request){

        //<editor-fold desc="Validation">
        $param_rules['job_id'] = "required";
        $param_rules['state'] = "required|in:complete,completed,uploading,processing,failed";

        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error){
            return $response;
        }
        //</editor-fold>

        
        $company = Company::getById($request['company_id']);
        $currentUser    = User::getById($request['user_id']);
        $hover = new Hover($company);

        $hover->updateTestJob($request['job_id'],$request['state'],$currentUser['email']);
        $response = $hover->getCompleteResponse();

        if($response['code'] != 200){
            return $this->__sendError('Hover Error',$response['message'] ?:"No Message",$response['code'] );
        }

        $this->__is_collection = false;
        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Project', $response, 200, __('app.success_store_message'));
    }

    public function getMeasurements(Request  $request){

        //<editor-fold desc="Validation">
        $param_rules['job_id'] = "required|exists:hover_jobs,job_id,deleted_at,NULL";
        $param_rules['project_ref_id'] = "nullable|exists:hover_jobs,project_ref_id,deleted_at,NULL";
        $param_rules['version'] = "required|in:full_json";

        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error){
            return $response;
        }
        //</editor-fold>

        $hJobM = new HoverJob();
        $hJob = $hJobM::getBy(['job_id' => $request->job_id ]);

        $request['type'] = 2;

        $tags = Tag::getCompanyHoverFields($request->all());

        $hover = new Hover(Company::getById($request['company_id']));

        if(empty($hJob[0]->json_response) OR empty($hJob[0]->file_path)){

            /** Get Meausurements from Hover API*/
            $measurements = $hover->getFullMeasurements($hJob[0]->job_id,'json',$request->version);
            $filePath = $hover->getFullMeasurements($hJob[0]->job_id,'pdf');

            if($hover->getCompleteResponse()['code'] != 202){
                $this->__collection = false;
                $this->__is_paginate = false;
                return $this->__sendResponse('Tag',[], 202 ,'Hover report hasn\'t been completed yet.');
            }

            /** updating to db*/
            $res = $hJobM->updateResponse($request->all(),$measurements,$filePath);
            if (!$res) {
                return $this->__sendError('Notice', ['error' => 'Hover report hasn\'t been saved to db.'], 400);
            }
//            $photoViewResponse = $hover->parseJob($tags);
            $photoViewResponse = $hover->parseJobCompletely([],$tags);
        } else {
            /** Get Meausurements from DB JSON*/

            $photoViewResponse = $hover->parseJobCompletely($hJob[0]->json_response,$tags);
//            $photoViewResponse = $hover->parseJob($tags,$hJob[0]->json_response);
        }

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Tag',$photoViewResponse, 200 ,__('app.success_listing_message'));
    }

    public function getMeasurementsReport(Request  $request){

        //<editor-fold desc="Validation">
        $param_rules['job_id'] = "required|exists:hover_jobs,job_id,deleted_at,NULL";
        $param_rules['project_ref_id'] = "nullable|exists:hover_jobs,project_ref_id,deleted_at,NULL";
        $param_rules['version'] = "nullable|in:full_json";

        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error){
            return $response;
        }
        //</editor-fold>

        $hJobM = new HoverJob();
        $hJob = $hJobM::getBy(['job_id' => $request->job_id ]);

        if(empty($hJob[0]->file_path)){
            return $this->__sendError('Report Not Found',[],400);
        }

        /** Will be needed if client wanted to fetch report without depending on fetching json */
       if(FALSE){
           $request['type'] = 2;

           $tags = Tag::getCompanyHoverFields($request->all());

           $hover = new Hover(Company::getById($request['company_id']));

           if(empty($hJob[0]->json_response) OR empty($hJob[0]->file_path)){
               /** Get Meausurements from Hover API*/
               $measurements = $hover->getFullMeasurements($hJob[0]->job_id,'json',$request->version);

               $filePath = $hover->getFullMeasurements($hJob[0]->job_id,'pdf');


               if($hover->getCompleteResponse()['code'] != 200){
                   return $this->__sendError('Notice',['error' => 'Hover report hasn\'t been completed yet.'],400);
               }

               /** updating to db*/
               $res = $hJobM->updateResponse($request->all(),$measurements,$filePath);
               if (!$res) {
                   return $this->__sendError('Notice', ['error' => 'Hover report hasn\'t been saved to db.'], 400);
               }
               //$photoViewResponse = $hover->parseJob($tags);
               $photoViewResponse = $hover->parseJobCompletely($hJob[0]->json_response,$tags);
           } else {
               /** Get Meausurements from DB JSON*/
               //$photoViewResponse = $hover->parseJob($tags,$hJob[0]->json_response);
               $photoViewResponse = $hover->parseJobCompletely($hJob[0]->json_response,$tags);
           }
       }

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Tag',['link' => url(config('constants.HOVER_FILE_PATH').$hJob[0]->file_path)], 200 ,__('app.success_listing message'));
    }

    public function getSampleMeasurements(Request  $request){
        //<editor-fold desc="Validation">
        $param_rules['job_id'] = "nullable";
//        $param_rules['project_id'] = "required|exists:hover_jobs,project_id,deleted_at,NULL";
        $param_rules['version'] = "required|in:full_json";

        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error){
            return $response;
        }
        //</editor-fold>

        $request['type'] = 2;
        $tags = Tag::getCompanyHoverFields($request->all());

        $hover = new Hover(Company::getById($request['company_id']));
        $tagResponse = $hover->parseJob($tags,$hover->sampleJob);

        $this->__collection = true;
        $this->__is_paginate = false;
        return $this->__sendResponse('Tag',$tagResponse, 200 ,__('app.success_listing message'));
    }

    public function statusWebhook(Request $request){
        Log::info("statusWebhook Log: ".json_encode($request->all()));
    }

    public function testJob(Request $request){

        Log::info("testJob Log: ".json_encode($request->all()));
        echo json_encode($request->all());
    }

    public function parseJob(Request $request){
        $hover = new Hover(Company::getById($request['company_id']));
        $hover->parseReport();
    }

}

