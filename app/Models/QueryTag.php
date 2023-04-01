<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class QueryTag extends Model
{
    protected $table = "query_tag";

    use SoftDeletes;

    protected $fillable = [
        'query_id','name','target_id',
    ];

    protected $dates = ['deleted_at'];

    public static function create($projectMediaId,$tags)
    {
        $insert = [];
        foreach ($tags AS $key => $item){

            $insert[$key]['target_id'] = $projectMediaId;
            $insert[$key]['target_type'] = 'media';
            $insert[$key]['tag_id'] = $item['id'];
            $insert[$key]['qty'] = $item['quantity'];
            $insert[$key]['created_at'] = ''.date('Y-m-d H:i:s');
        }

//        print_r($insert);
        return self::insert($insert);
//        print_r($res); die;

    }

    public static function getById($id)
    {
        $query = self::select();
        return $query->where('id', $id)->first();
    }

    public static function getByCategoryId($id)
    {
        $query = self::select();
        return $query->where(['target_id' => $id , 'target_type' => 'media'])->get();
    }


    public static function getList($param)
    {
        $query = self::select();
        $query->where('company_id', $param['company_id']);

        if (!empty($param['keyword'])) {
            //echo "AAA";die;
            $keyword = $param['keyword'];
//            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
                $where->orWhere('address1', 'LIKE', "'%$keyword%'");
            });
        }
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function storeCompanyGroupCategory($request)
    {
        return \DB::table('company_group_category')->insertGetId([
        ]);
    }

    public static function deleteQueryTagByQueryId($id){
        return self::where('query_id',$id)->delete();
    }
}
