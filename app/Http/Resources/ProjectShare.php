<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class ProjectShare extends Resource
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
            'project_id' => $this->project_id,
            /*'share_token' => $this->share_token,*/
            'recipient_email' => $this->recipient_email,
            'status' => $this->status,
            'creator_id' => $this->creator_id
        ];

        $response['project'] = $this->relationLoaded('project') ? new Project($this->project) : new \stdClass();
        $response['media'] = $this->relationLoaded('media') ? ProjectShareMedia::collection($this->media) : [];

        return $response;
    }
}
