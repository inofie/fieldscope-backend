<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }
}
