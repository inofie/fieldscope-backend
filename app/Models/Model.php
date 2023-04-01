<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model AS BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Model extends BaseModel
{

    protected $relations = [];
    public function getById($id){
        $query = $this->select();
        return $query->where('id', $id)
            ->first();
    }
}
