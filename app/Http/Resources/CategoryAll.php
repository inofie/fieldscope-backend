<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class CategoryAll extends Resource
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
            'company_id' =>             $this->company_id,
            'user_group_title' =>             $this->user_group_title,
            'min_quantity' =>           $this->min_quantity,
            'name' =>           $this->name,
            'parent_id' =>          $this->parent_id,
            'created_at' => date('m-d-Y', strtotime($this->created_at)),
        ];

        return $response;
    }
}
