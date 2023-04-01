<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Notification extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $actor_user = \App\Models\User::miniObject($this->actor_id);
        $username   = $actor_user->first_name . ' ' . $actor_user->last_name;
        return [
            'id'          => $this->id,
            'product_id'          => $this->product_id,
            'identifier'  => $this->identifier,
            'reference_id'  => $this->reference_id,
            'reference_module'  => $this->reference_module,
            'actor_user'       => $actor_user,
            'target_user'    => \App\Models\User::miniObject($this->target_id),
            'title'       => $this->title,
            'notif_description' => $this->identifier != 'add_message' ? $this->description : str_replace($username,'',$this->description),
            'is_read'     => $this->is_read,
            'created_at'  => date('Y-m-d H:i:s', strtotime($this->created_at)),
        ];
    }
}
