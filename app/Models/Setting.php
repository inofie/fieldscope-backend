<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "setting";

    public static function getByKey ($key)
    {
        return self::select('value')
                ->where('key', $key)
                ->first();
    }
}
