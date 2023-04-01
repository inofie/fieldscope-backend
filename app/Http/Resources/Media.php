<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class Media extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'media_type' => $this->media_type,
            'path' => (empty($this->path)) ? '' : env('BASE_URL').Config::get('constants.MEDIA_IMAGE_PATH').$this->path,
            ];
    }
}
