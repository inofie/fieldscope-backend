<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Subscription extends Model
{
    protected $table = "subscription";
    protected $fillable = ['type', 'key', 'title', 'amount', 'per_user_amount', 'description', 'duration', 'duration_unit',
        'total_tiers', 'total_featured_deals', 'created_at', 'updated_at', 'deleted_at' ];

    use SoftDeletes,GeneralModelTrait;

    public static function getList($param)
    {
        $query = self::select();

        if (!empty($param['keyword'])) {
            //echo "AAA";die;
            $keyword = $param['keyword'];
//            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
            });
        }
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getById($id){
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function resubscribe(){

    }


}
