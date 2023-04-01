<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CrmProject
{
    /**
     * Transform the resource into an array.
     *
     * @param  data
     * @return array
     */
    public function toArray($data)
    {
        return [
            'crm_project_id' => $data['id'],
            'crm_project_title' => $data['name'],
        ];
    }
}
