<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class ProjectShareMedia extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            //'project_share_id' => $this->project_share_id,
            'media_id' => $this->media_id,
            'image_url' => $this->image_url,
        ];

        return $response;
    }
}
