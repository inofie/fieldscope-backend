<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "states";

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }



}
