<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class Tag extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        $image_url = ($this->gender == 'female') ? env('BASE_URL') . Config::get('constants.GENERAL_IMAGE_PATH') . 'female.png' : env('BASE_URL') . Config::get('constants.GENERAL_IMAGE_PATH') . 'male.png';
//        $user_exist_image = ($this->user_group_id == 3) ? env('BASE_URL') . '/' . $this->image_url : env('BASE_URL') . Config::get('constants.USER_IMAGE_PATH') . $this->image_url;
//        $user_exist_image = (filter_var($this->image_url, FILTER_VALIDATE_URL)) ? $this->image_url : $user_exist_image;

//        pd($this->created_at,'$this->created_at');
        $response = [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'ref_id' => $this->ref_id,
            'ref_type' => $this->ref_type,
            'quantity' => (!empty($this->quantity)) ? $this->quantity : 0,
            'has_qty' => $this->has_qty,

            'hover_field_type_id' => $this->hover_field_type_id,
            'hover_field_type_slug' => $this->field_type_slug,
            'hover_field_id' => $this->hover_field_id,
            'hover_field_name' => $this->hover_field_name,
            /*'field_type_slug' => $this->field_type_slug,
            'method' => $this->method,
        'config_path' => $this->config_path,
        'params' => $this->params,*/
            'hover_value' => $this->hover_value,
            'hover_data_title' => $this->hover_data_title,
            'hover_data' => $this->hover_data,
            'created_at' => !empty($this->created_at) ? date('Y-m-d H:i:s', $this->created_at,'') : null,
        ];

        return $response;
    }
}
