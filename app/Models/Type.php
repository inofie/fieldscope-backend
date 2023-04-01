<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "type";

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function createTenantType($company_id)
    {
        \DB::statement("INSERT INTO `type` (`code`, title, tenant_id, created_at, updated_at) 
            SELECT `code`, title, $company_id, NOW(), NOW() FROM `type` WHERE tenant_id = 0 AND deleted_at IS NULL");

        return;
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

}
