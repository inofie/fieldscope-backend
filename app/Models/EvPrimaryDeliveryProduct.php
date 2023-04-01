<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvPrimaryDeliveryProduct extends Model
{
    protected $table = "ev_primary_delivery_product";

    protected $fillable = ['primary_product_id', 'delivery_product_id', 'created_at', 'updated_at', 'deleted_at'];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

}
