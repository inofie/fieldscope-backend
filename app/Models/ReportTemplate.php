<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate     extends Model
{
    use GeneralModelTrait, SoftDeletes;
    protected $table = "report_templates";

    protected $fillable = ['id', 'company_id', 'identifier', 'title', 'content', 'path',
        'created_at', 'updated_at', 'deleted_at'];


    public function getSelectedTemplates($params){

        $query = self::select("*");
        $query->where(['company_id' => $params['company_id'] ]);


        $query->where(function ($q) use ($params) {
            if ($params['ids'])
                $q->orWhereIn('id', $params['ids']);

            if ($params['identifiers'])
                $q->orWhereIn('identifier', $params['identifiers']);
        });


//        dd($params,getRawQuery($query));

        return $query->get(['id', 'company_id', 'identifier', 'title', 'content', 'path']);
    }
}
