<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Config;

class ProjectMedia extends Resource
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
            'category_id' =>    $this->category_id,
            'category_name' =>  $this->category_name,
            'category_min_quantity' =>  $this->category_min_quantity,
            'children' =>   $this->children,
            'media' =>  $this->media
        ];

        return $response;
    }
}
