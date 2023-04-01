<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class HoverTags extends Resource
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

        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'company_id' => $this->company_id,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'min_quantity' => $this->min_quantity,
            'thumbnail' => $this->thumbnail,
            'order_by' => $this->order_by,
            'created_at' => date('m-d-Y', strtotime($this->created_at)),
        ];


        return $response;
    }
}
