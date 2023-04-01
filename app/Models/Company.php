<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";

    protected $fillable = [

        'title',
        'primary_user_id',
        'image_url',
        'website',
        'description',
        'created_at',
        'updated_at',
        'crm_employee_email',
        'crm_employee_id',
        'ev_email',
        'ev_password'
    ];

    public static function create($company)
    {
        $name = $company['first_name'];
        if (!empty($company['last_name']))
            $name .= $company['last_name'];

        $obj = new static();

        $obj->title = $name;
        $obj->image_url = $company['image_url'];
        $obj->primary_user_id = $company['primary_user_id'];
        //$obj->website           = $company['website'];
        //$obj->description       = $company['description'];

        $obj->save();

        return $obj->id;
    }

    public static function getById($id){
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getPrimaryUser($id){
        $query = self::select();
        $query->join('user','user.id','=','company.primary_user_id');
        return $query->where('company.id', $id)
            ->first();
    }

    public static function getUniqueHoverRefCode(){
        $ref_code = null;
        do {
            $ref_code = str_random(70);
        } while (Company::where("hover_ref_code","=", $ref_code)->first() instanceof Company);

        return $ref_code;
    }

}
