<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvCompanyProduct extends Model
{
    protected $table = "ev_company_product";

    protected $fillable = ['company_id', 'ev_primary_product_id', 'ev_delivery_product_id', 'created_at', 'updated_at', 'deleted_at'];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function addCompanyProducts($params){

        $res = false;
        foreach($params['delivery_product_id'] AS $key => $item){

            foreach($item AS $key2 => $item2){
                $res = false;
                $ins = [
                    'company_id' => $params['company_id'],
                    'ev_primary_product_id' => $key,
                    'ev_delivery_product_id' => $item2
                ];

                $res = self::firstOrCreate($ins );
            }
        }

        if(!($res)){
            return ['error' => 'Failed to add.'];
        }
        return true;
    }

}
