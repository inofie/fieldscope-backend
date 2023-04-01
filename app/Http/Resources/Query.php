<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Query extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id'                => $this->id,
            'company_id'        => $this->company_id,
            'project_id'        => $this->project_id,
            'query'             => $this->query,
            'type'              => $this->type,
            'category_id'       => $this->category_id,
            'options'           => !empty($this->options) ?  $this->optionExplode($this->options) : NULL,
            'user_response'     => !empty($this->project_id) ? $this->userResponse : NULL,
            'created_at'        => $this->created_at,
//            'updated_at'        => $this->updated_at,
//            'deleted_at'        => $this->deleted_at
        ];

        return $response;
    }

    public function optionExplode($options)
    {
        $options = explode(',', $options);
        $arr = [];
        foreach ($options AS $key => $item) {
            $arr[$key] = [
                'title' => $item,
                'is_selected' => false
            ];
        }
        return $arr;
    }

}
