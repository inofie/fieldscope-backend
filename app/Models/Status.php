<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "status";

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getByCode($id = 0, $code, $tenant_id){

        $query = self::select();
        if(!empty($id))
            $query->where('id', '!=', $id);
        return $query->where('code', $code)
            ->where('tenant_id', $tenant_id)
            ->whereNull('deleted_at')
            ->count();
    }

    public static function getFirstTenantStatus($tenant_id){

        $query = self::select();
        $result = $query->where('tenant_id', $tenant_id)
            ->orderBy('id')
            ->whereNull('deleted_at')
            ->first();
        if(!$result->count())
            return 1;

        return $result['id'];
    }

    public static function getList($params){
        $query = self::select('status.*',\DB::raw( "0 as lead_percentage"));
        return $query->whereIn('tenant_id', [$params['company_id']])
            ->whereNull('deleted_at')
            ->get();
    }

    public static function incrementLeadCount($status_id){
        \DB::table('status')
            ->where('id',$status_id)
            ->increment('lead_count');
    }

    public static function decrementLeadCount($status_id){
        \DB::table('status')
            ->where('id',$status_id)
            ->decrement('lead_count');
    }

    public static function createTenantStatus($company_id)
    {
        \DB::statement("INSERT INTO status (`code`, title, color_code, lead_count, tenant_id, created_at, updated_at) 
            SELECT `code`, title, color_code, 0, $company_id, NOW(), NOW() FROM status WHERE tenant_id = 0 AND deleted_at IS NULL");

        return;
    }
}
