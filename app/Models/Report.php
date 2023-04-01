<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Report     extends Model
{
    use GeneralModelTrait, SoftDeletes;
    protected $table = "reports";

    protected $fillable = ['id', 'user_id', 'project_id', 'token','path', 'options', 'inspector_sign', 'inspector_sign_at',
        'customer_sign', 'customer_sign_at',
        'created_at', 'updated_at', 'deleted_at'];

    public function createReport($request){

//        dd('$request',$request);
        dd('create',[
            'user_id' => $request['user_id'],
            'project_id' => (int) $request['project_id'],
            'token' => uniqid()."-".time(),
            'options' => $request['options']
        ]);

        self::updateOrCreate([

        ],[
            'user_id' => $request['user_id'],
            'project_id' => $request['project_id'],
            'token' => uniqid()."-".time(),
            'options' => $request['options']
        ]);
    }

    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }


}
