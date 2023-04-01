<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class Company extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image_url = ($this->gender == 'female') ? env('BASE_URL') . Config::get('constants.GENERAL_IMAGE_PATH') . 'female.png' : env('BASE_URL') . Config::get('constants.GENERAL_IMAGE_PATH') . 'male.png';
        $user_exist_image = ($this->user_group_id == 3) ? env('BASE_URL') . '/' . $this->image_url : env('BASE_URL') . Config::get('constants.USER_IMAGE_PATH') . $this->image_url;
        $user_exist_image = (filter_var($this->image_url, FILTER_VALIDATE_URL)) ? $this->image_url : $user_exist_image;

        $response = [
            'id' => $this->id,
            'title' => $this->first_name . ' ' . $this->last_name,
            'primary_user_id' => $this->primary_user_id,
            'image_url' => (empty($this->image_url)) ? $image_url : $user_exist_image,
            'website' => $this->website,
            'description' => $this->description,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'company_id' => $this->company_id,
//            'mobile_no' => (empty($this->mobile_no))? '' : $this->mobile_no,
//            'date_of_join' => (empty($this->date_of_join))? '' : date('Y-m-d', strtotime($this->date_of_join)),
            //'image_url' => (empty($this->image_url)) ? '' : env('BASE_URL').Config::get('constants.USER_IMAGE_PATH').$this->image_url,
            'token' => $this->token,
            //'token_expiry_at' => date('m-d-Y', strtotime($this->token_expiry_at)),

            'user_group_id' => $this->user_group_id,
            'device_type' => $this->device_type,
            'device_token' => $this->device_token,
            'device' => $this->device,
            'created_at' => date('m-d-Y', strtotime($this->created_at)),
        ];

        return $response;
    }
}
