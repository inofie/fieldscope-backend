<?php

namespace App\Http\Controllers;

use App\Libraries\JobScope;
use App\Libraries\Helper;
use App\Libraries\Payment\Stripe;
use App\Models\Company;
use App\Models\CompanyGroup;
use App\Models\CompanyGroupCategory;
use App\Models\Subscription;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Project;
use App\Models\CompanySubscriptionRelation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->_stripe = new Stripe;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->__view = 'web/welcome';
        $subs = Subscription::all()->toArray();

        $pSubs = ['basic' => [], 'plus' => []];
        foreach ($subs AS $key => $item) {
            $pSubs[$item['type']][] = $item;
        }
        $list['subs'] = $pSubs;
//        Helper::p($subs,'$subs');
//        Helper::pd($pSubs,'$pSubs');

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }


    public function registerView($planType = 'basic')
    {
        $this->__view = 'web/signup';
        $list['subs'] = Subscription::where(['type' => $planType])->get()->toArray();
        $list['plan_type'] = $planType;
//        Helper::pd($list['subs'],'$list[\'subs\']');

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');

    }

    private $_stripe;

    public function register(Request $request, $planType = 'basic')
    {
        $this->__view = 'signup/' . $planType;
        $this->__is_redirect = true;

        //region Validation
//        $param_rules['plan'] = 'required|string|max:100';
        $param_rules['name'] = 'required|string|max:100';
//        $param_rules['email'] = 'required|string|max:100';
        $param_rules['email']       = 'required|unique:user|string|email|max:150|unique:user,deleted_at,NULL';
        $param_rules['password'] = 'required|string|max:100|confirmed';
        $param_rules['mobile_no'] = 'required|string|max:100';
//        $param_rules['stripeToken'] = 'required|string|max:100';
//        $param_rules['image_url'] = 'required|image';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Signed-up Successfully', $error['data']);
            return $response;
        }
        //endregion

        $selectedSub = Subscription::getById($request->plan);

//        if ($request->hasFile('image_url')) {
//            // $obj is model
//            $request['image'] = $this->__moveUploadFile(
//                $request->file('image_url'),
//                md5($request['email'] . $request['device_token']),
//                config('constants.USER_IMAGE_PATH')
//            );
//        }

        $request['password'] = $this->__encryptedPassword($request['password']);

        $request['plan'] = Subscription::where(['type' => 'free' , 'key' => '14day_free' ])->first();

        $result = User::createCompany($request->all());

        $stripCustomer = $this->_stripe->createCustomer($request['email']);
        User::where('id',$result['user'])->update([
            'stripe_customer_id' => $stripCustomer['data']['customer_id']
        ]);

        //region Disabled Stripe Payment Block
       if(FALSE){

           if ($stripCustomer['code'] != 200) {
               $errorMessages['error'] = $stripCustomer['message'];
               $this->__setFlash('Failed', $stripCustomer['message']);
//         return $this->__sendError('Error',$errorMessages,400);
           }
           else {

               $stripeResponse = $this->_stripe->createCustomerNewCard($stripCustomer['data']['customer_id'], $request['stripeToken']);

               if ($stripeResponse['code'] != 200) {
                   return $this->__sendError('Stripe Error', ['message' => $stripeResponse['message']]);
               } else {
                   $charge_data = [
                       'amount' => $selectedSub->amount,
                       'currency' => env('STRIPE_CHARGE_CURRENCY'),
                       'source' => $stripeResponse['data']->id,
                       'customer' => $stripCustomer['data']['customer_id'],
                       'description' => 'Charge for subscription ' . $selectedSub->title,
                       'transfer_group' => $transfer_group,
                   ];
                   $charge = $this->_stripe->createCharge($charge_data);
//                Helper::p($charge,'$charge');

                   if ($charge['code'] != 200) {
                       return $this->__sendError('Stripe Error', ['message' => $charge['message']]);
                   }



                   $sender = User::getById($result['user']);
                   Transactions::addSubscriptionPlan($sender,'',$selectedSub,$charge_data,$charge);
               }

           }
       }
        //endregion

        if ($result['user'] < 1 || $result['company'] < 1 || $result['userSubRel'] < 1) {
            $this->__setFlash('danger', 'Not Signed-up Successfully');
        } else {
            $this->__view = 'subadmin/login';
        }

        $this->__setFlash('success', 'Account Created, You can login');
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function layoutAbout()
    {
        return view('layouts/about');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function layoutSecurity()
    {
        return view('layouts/security');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function layoutPayment()
    {
        return view('layouts/payment');
    }

    public function generatePDF()
    {
//        PDF::loadView('pdf', [], [], [
//            'title' => 'Another Title',
//            'margin_top' => 0
//        ])
//            ->save(public_path('test.pdf'));


        $header = view('header')->render();
        $footer = view('footer')->render();
        $content = view('pdf')->render();
        $pdf = PDF::loadView('pdf', [], [], [
            'title' => 'Another Title',
            'margin_top' => 0
        ]);
        $pdf->getMpdf()->SetHTMLHeader($header);
        $pdf->getMpdf()->SetHTMLFooter($footer);
        return $pdf->stream('document.pdf');
    }

    public function dashboard(Request $request)
    {

        $company_id = $request['company_id'];
        $data['getLastWeekProject'] = \DB::select("select count(*) as total_project, DATE(created_at) as created_at from project where company_id = {$company_id} AND `created_at` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP by DATE(created_at)");

        $data['projectsPerDay'] = array_column($data['getLastWeekProject'],'total_project');
        $data['dates'] = array_column($data['getLastWeekProject'],'created_at');

        $data['user']           = User::where('id',$request['user_id'])->whereNull('deleted_at')->first();
        $data['total_users']    = User::where('company_id',$request['company_id'])->whereNull('deleted_at')->count();
        $data['total_projects'] = Project::where('company_id',$request['company_id'])->whereNull('deleted_at')->count();

//        pd( $data['user'],'user');

        return view('subadmin/analytics',$data);
    }


}
