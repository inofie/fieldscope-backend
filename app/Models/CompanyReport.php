<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyReport extends Model
{
    use GeneralModelTrait, SoftDeletes;
    protected $table = "company_reports";

    protected $fillable = [ 'company_id', 'logo_path', 'primary_color', 'secondary_color', 'name', 'email', 'phone',
        'website', 'services', 'report_name', 'report_cover_image', 'is_footer_user_name', 'is_footer_user_email',
        'is_footer_user_phone', 'credit_disclaimer', 'is_disclaimer', 'estimate_terms', 'footer_disclaimer', 'json_data' ];


    public function getReportContent($params){

        $query = self::select("*");

        $query
            ->join("report_templates","report_templates.company_id")
            ->where(['company_id' => $params['company_id'] ])->get();
    }

}
