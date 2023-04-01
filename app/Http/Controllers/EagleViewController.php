<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\EagleView;
use App\Models\Company;
use App\Models\EvCompanyProduct;
use App\Models\EvProduct;
use App\Models\EvProductFields;
use App\Models\EvProjectReports;
use App\Models\Project;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EagleViewController extends Controller
{

    private $_company;
    function __construct(Request $request)
    {
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes
        ini_set('max_execution_time', 0); // for infinite time of execution
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'index', 'productsList','setProducts', 'orderReport', 'authorizeUser','fetchReport']
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

    public function setProducts(Request $request)
    {
        $company = Company::getById($request['company_id']);

        $ev = new EagleView($company);

        $response = $ev->getAvailableProducts();

        $res = EvProduct::addProductsFromEv($response['data']);

        if ($res['error']) {
            return $this->__sendError('Query Error', $res['error']);
        }

        $this->__collection = false;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', [], '200', 'Eagleview Products Added Successfully');
    }

    public function productsList(Request $request)
    {
        $evProductM = new EvProduct();
        $products = $evProductM->getCompanyAllowedProducts($request->all());

        $products = array_values($products);

        $this->__collection = false;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', $products, '200', 'Eagleview Products Added Successfully');
    }

    public function orderReport(Request $request){

        //<editor-fold desc="Validation">
        //@formatter:off
        $param_rules['address']                      = 'required_without:project_id';
        $param_rules['state']                        = 'required_without:project_id';
        $param_rules['city']                         = 'required_without:project_id';
        $param_rules['postal_code']                  = 'required_without:project_id';
//        $param_rules['latitude']                     = 'required_without:project_id';
//        $param_rules['longitude']                    = 'required_without:project_id';
        $param_rules['ref_id']                       = 'required_without:project_id';

//        $param_rules['project_id']                   = 'required_without:address,state,city,latitude,longitude|exists:project,id';
        $param_rules['primary_product_id']           = 'required';
        $param_rules['delivery_product_id']          = 'required';
        $param_rules['measurement_instruction_type'] = 'required';
        $param_rules['changes_in_last_4_years']      = 'required';
        //@formatter:on

        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;
        //</editor-fold>

        $project = NULL;
        if(!empty($request['project_id'])){
            $project = Project::getById($request['project_id']);
        }

        $ev = new EagleView(Company::getById($request['company_id']));
        $ev->intializeOrder($request->all(),$project);
        $response = $ev->orderReport();

        if($response['code'] != 200){
            $error = ['error' => !empty($response['message']) ? $response['message'] : 'Unable to order Eagleview report'];
            $error['hint'] = "HINT: Add valid details (state, city, address & postal code)";
            return $this->__sendError('Eagleview Error',$error, $response['code']);
        }

        $evPReport = new EvProjectReports();

        $evPReport->createRecord($request->all(), $response['data'] ,$ev->_order);

        $this->__collection = false;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', ['report_id' => $response['data']['ReportIds'][0] ],'200',!empty($response['message']) ? $response['message'] : 'Eagleview Report Ordered Successfully.');
    }

    public function fieldList(Request $request, $id)
    {
        $evPFields = EvProductFields::where(['primary_product_id' => $id])->get();

        $this->__collection = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', $evPFields, '200', 'Eagleview Products Added Successfully');
    }

    public function fetchReport(Request $request)
    {

        //<editor-fold desc="Validation">
        //@formatter:off
        $param_rules['report_id']      = 'required|exists:ev_project_reports,report_id';
        //@formatter:on

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;
        //</editor-fold>

        $eagleView = new EagleView(Company::getById($request['company_id']));

        $evProjectReport = EvProjectReports::where(['report_id' => $request['report_id']])->first();

        $response = $eagleView->getReport($request['report_id']);

        EvProjectReports::where(['report_id' => $evProjectReport['report_id']])->update(['status_id' => $response['data']['StatusId']]);

        if (/*$response['data']['StatusId'] != 5*/ FALSE) {
            return $this->__sendError($evProjectReport->status[$evProjectReport['status_id']]['description'], [], '400');
        }

        $evProduct = new EvProductFields();
        $evFields = $evProduct->getEvFields($request->all(), $response['data']);

        $this->__collection = false;
        $this->__is_collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('EagleView', $evFields, '200', $evProjectReport->status[$evProjectReport['status_id']]['description']);
    }

    public function authorizeUser(Request $request)
    {
        $this->__is_redirect = true;
        $this->__view = 'subadmin/settings';

        //<editor-fold desc="Validation">
        $param_rules['ev_email']    = 'required|email';
        $param_rules['ev_password'] = 'required';
        $param_rules['authorize_orders'] = 'required';
        $response =  $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error){
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Authorization Failed', $error['data']);
            return $response;
        }
        //</editor-fold>

        Company::where('id',$request['company_id'])->update(['ev_email' => $request['ev_email'] ,
            'ev_password' => $request['ev_password']  ]);

        $this->__setFlash('success', 'Authorization Successful !');

        $this->__view = 'subadmin/settings';

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }

    public function companyProducts(Request $request){

        $this->__is_redirect = true;
        $this->__view = 'subadmin/settings';

        $res = EvCompanyProduct::addCompanyProducts($request->all());

        $this->__setFlash('success', 'EagleView Products Set Successfully!');

        if(!empty($res['error'])){
            $this->__setFlash('danger', $res['error']);
        }

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }


    public function hover_log(Request $request){

        Log::info("Hover Log: ".json_encode($request->all()));

//        $this->__is_redirect = true;
//        $this->__view = 'subadmin/settings';
//
//        $res = EvCompanyProduct::addCompanyProducts($request->all());
//
//        $this->__setFlash('success', 'EagleView Products Set Successfully!');
//
//        if(!empty($res['error'])){
//            $this->__setFlash('danger', $res['error']);
//        }

        die(json_encode(['message' => 'Logged']));
        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }

}

