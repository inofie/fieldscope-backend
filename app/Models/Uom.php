<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use GeneralModelTrait, SoftDeletes;
    protected $table = "uoms";

    protected $fillable = ['title','created_at', 'updated_at', 'deleted_at'];


}
