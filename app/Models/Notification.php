<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $table = "notification";

    protected $fillable = ['notification_identifier_id','actor_id','target_id','reference_id','reference_module','type','title',
        'description','is_notify', 'is_read', 'is_viewed', 'created_at','updated_at','deleted_at'];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function countUnreadByTargetId($targetId){

        $query = self::selectRaw('COUNT(*) AS notification_count');
        return $query->where('target_id', $targetId)->where('is_read' , 0)
            ->first();
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','reference_id','id');
    }

    public function productRequest(){
        return $this->belongsTo('App\Models\ProductRequest','reference_id','id')
            ->join('product_request AS pr','reference_id','=','pr.id')
            ->join('product AS p','pr.product_id','=','p.id')->selectRaw('
                p.id  
                p.name,
                p.user_id,  
                p.category_id
            ');
    }
}
