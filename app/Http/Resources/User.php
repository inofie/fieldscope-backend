<?php

namespace App\Http\Resources;

use App\Models\UserGenre;
use App\Models\UserProperty;
use App\Models\UserWishlist;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image_url = ($this->gender == 'female')? env('BASE_URL').Config::get('constants.GENERAL_IMAGE_PATH').'female.png': env('BASE_URL').Config::get('constants.GENERAL_IMAGE_PATH').'male.png';
        $user_exist_image = ($this->user_group_id == 3)? env('BASE_URL').'/'.$this->image_url : env('BASE_URL').Config::get('constants.USER_IMAGE_PATH').$this->image_url;
        $user_exist_image = (filter_var($this->image_url, FILTER_VALIDATE_URL))? $this->image_url : $user_exist_image;

//        pd($this->company_group,'$this->company_group');
        $response = [
            'id' => $this->id,
          'company_id' => $this->company_id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
//            'mobile_no' => (empty($this->mobile_no))? '' : $this->mobile_no,
//            'date_of_join' => (empty($this->date_of_join))? '' : date('Y-m-d', strtotime($this->date_of_join)),
            'image_url' => (empty($this->image_url)) ? $image_url : $user_exist_image,
            //'image_url' => (empty($this->image_url)) ? '' : env('BASE_URL').Config::get('constants.USER_IMAGE_PATH').$this->image_url,
            'token' => $this->token,
            //'token_expiry_at' => date('m-d-Y', strtotime($this->token_expiry_at)),
            //'is_subscribed' => \App\Models\User::verifySubscription($this->id, $this->user_group_id, $this->subscription_expiry_date),

            'group_title' => $this->group_title,
            'user_group_id' => $this->company_group_id,
            'user_group' => $this->companyGroup->title,
            'hover_user' => !empty($this->hover_user_id) ? true : false ,

            'device_type' => $this->device_type,
            'device_token' => $this->device_token,
            'device' => $this->device,
            'created_at' => date('m-d-Y', strtotime($this->created_at)),
        ];

//        $response['user_group'] = $this->whenLoaded('user_group') ? new CompanyGroup($this->user_group) : new \stdClass();
        return $response;
    }
}
