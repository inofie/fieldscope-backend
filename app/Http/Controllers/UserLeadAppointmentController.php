<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Models\Lead;
use App\Models\UserLeadAppointment;
use Illuminate\Http\Request;

class UserLeadAppointmentController extends Controller
{
    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param_rules['search'] = 'sometimes';
        $param_rules['appointment_date'] = 'nullable';//date("Y-n-j G:i");
        $param_rules['is_out_bound'] = 'nullable|IN:1,0';//date("Y-n-j G:i");


        $param['search'] = isset($request['search']) ? $request['search'] : '';
        $param['is_out_bound'] = isset($request['is_out_bound']) ? ($request['is_out_bound'] === '0')? 0 : 1 : '';
        $param['appointment_date'] = '';
        if(isset($request['appointment_date'])) {
            $date_format = '|date_format:"Y-n"';
            $date_str = explode('-',$request['appointment_date']);
            $param['appointment_date'] = date("Y-m", strtotime($request['appointment_date']));
            if(count(((array) $date_str)) > 2) {
                $date_format = '|date_format:"Y-n-j"';
                $param['appointment_date'] = date("Y-m-d", strtotime($request['appointment_date']));
            }
            $param_rules['appointment_date'] .= $date_format;
            $this->__is_paginate = false;
        }

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $param['user_id'] = $request['user_id'];
        $param['company_id'] = $request['company_id'];
        $param['type'] = 'lead';

        $response = UserLeadAppointment::getList($param);
        return $this->__sendResponse('UserLeadAppointment', $response, 200, 'Lead list retrieved successfully.');
    }

    public function createAppointment(Request $request)
    {
        $param_rules['lead_id'] = 'required|exists:lead,id';
        $param_rules['template_id'] = 'required|exists:mail_template,id';
        $param_rules['mail_appointment_date'] = 'nullable|date_format:"Y-n-j G:i"|after_or_equal:' . date("Y-n-j G:i");
        $param_rules['phone_appointment_date'] = 'nullable|date_format:"Y-n-j G:i"|after_or_equal:' . date("Y-n-j G:i");

        $appointment_date = explode(':', $request['mail_appointment_date']);
        $appointment_date_min = (isset($appointment_date[1])) ? ((strlen($appointment_date[1]) > 1)? $appointment_date[1] : "0{$appointment_date[1]}") : '00';
        $request['mail_appointment_date'] = "{$appointment_date[0]}:$appointment_date_min";

        $appointment_date = explode(':', $request['phone_appointment_date']);
        $appointment_date_min = (isset($appointment_date[1])) ? ((strlen($appointment_date[1]) > 1)? $appointment_date[1] : "0{$appointment_date[1]}") : '00';
        $request['phone_appointment_date'] = "{$appointment_date[0]}:$appointment_date_min";

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        if(empty($request['mail_appointment_date']) && empty($request['phone_appointment_date'])) {
            $errors['mail_appointment_date'] = 'Appointment date is required';
            return $this->__sendError('Validation Error.', $errors);
        }

        if(!empty($request['mail_appointment_date'])) {
            $obj_appointment = new UserLeadAppointment();
            $obj_appointment->lead_id = $request['lead_id'];
            $obj_appointment->user_id = $request['user_id'];
            $obj_appointment->result = $request['template_id'];
            $obj_appointment->appointment_date = $request['mail_appointment_date'];
            $obj_appointment->type = 'marketing_mail';
            $obj_appointment->save();
        }
        if(!empty($request['phone_appointment_date'])){
            $obj_appointment = new UserLeadAppointment();
            $obj_appointment->lead_id = $request['lead_id'];
            $obj_appointment->user_id = $request['user_id'];
            $obj_appointment->result = $request['template_id'];
            $obj_appointment->appointment_date = $request['phone_appointment_date'];
            $obj_appointment->type = 'marketing_phone';
            $obj_appointment->save();
        }



        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Lead', Lead::getById($request['lead_id']), 200,'Lead has been retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
