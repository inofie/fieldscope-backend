<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvDeliveryAddonProduct extends Model
{
    protected $table = "ev_delivery_addon_product";

    protected $fillable = ['delivery_product_id', 'addon_id', 'created_at', 'updated_at', 'deleted_at'];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

}
