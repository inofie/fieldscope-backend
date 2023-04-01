<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class Project extends Resource
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
            'company_id'        => $this->company_id,
            'user_id'           => $this->user_id,
            'name'              => $this->name,
            'address1'          => $this->address1,
            'address2'          => $this->address2,
            'assigned_user_id'  => $this->assigned_user_id,
            'state_id'          => $this->state_id,
            'state_name'        => $this->state_name,
            'city_id'           => $this->city_id,
            'city_name'         => $this->city_name,
            'postal_code'       => $this->postal_code,
            'claim_num'         => $this->claim_num,
            'inspection_date'   => $this->inspection_date,
            'latitude'          => $this->latitude,
            'longitude'         => $this->longitude,
            'customer_email'         => $this->customer_email,
            'is_updated'         => $this->is_updated,
            'sales_tax'         => $this->sales_tax,
            'categories'        => !empty($this->categories) > 0 ? $this->categories : NULL ,
            'media'             => !empty($this->project_media) > 0 ? $this->project_media : [] ,
            'project_media'     => !empty($this->getSingleMedia) > 0 ? $this->getSingleMedia->toArray() : [] ,
            'media_tag'         => !empty($this->media_tag) > 0 ? $this->media_tag->toArray() : [] ,
            'status_id'         => !empty($this->status_id) ? $this->status_id : NULL, // 1:initiated , 2:completed
            'project_status'    => !empty($this->project_status) ? $this->project_status : NULL, // 1:open , 2:closed
            'ref_id'            => $this->ref_id,
            'created_at'        => $this->created_at->toDateTimeString()
        ];

        if($this->relationLoaded('complete_address')){
            $response['state_name'] = $this->complete_address->state_name;
            $response['city_name'] = $this->complete_address->name;
        }else{
            $response['state_name'] = $this->state_name;
            $response['city_name'] = $this->city_name;
        }


        return $response;
    }
}
