<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class CompanyGroup extends Model
{
    protected $table = "company_group";

    use SoftDeletes;






    protected $dates = ['deleted_at'];

    public static function getById($id){
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getByCompanyId($id){
        $query = self::select();
        return $query->where('company_id', $id)
            ->first();
    }

    public static function getCompanyGroupList($param){
        $query = self::select();

        $query->where('company_id',$param['company_id']);

        if(!empty($param['keyword']) ){
            $keyword = $param['keyword'];
            $query->whereRaw("( id LIKE '%$keyword%' OR title LIKE '%$keyword%' )");
        }
        $query->orderBy('id','DESC');
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }


    public static function  getCompanyGroupDatatable($params){
        $output = [];
        parse_str($params['custom_search'], $output);

        $query = self::selectRaw('company_group.*')->with(['assigned_user']);
        $query->where('company_id',$params['company_id']);
//        $query->join('users AS u','u.company_group_id','company_group.id');
        if(!empty($output['keyword']) ){
            $keyword = $output['keyword'];
            $query->whereRaw("( id LIKE '%$keyword%' OR title LIKE '%$keyword%' )");
        }

        $sortMap = [
            'title',
        ];

        $data['total_record'] = $query->count();
        $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
        $query = $query->take($params['length'])->skip($params['start'])->orderBy($sortMap[$params['column_index']],$params['sort']);


        $query = $query->get();
//        \Log::debug('$records'.print_r($query->toArray(),1));
        $data['records'] = $query;
        return $data;
    }

    public function assigned_user(){
        return $this->hasMany('App\Models\User','company_group_id','id')
            ->selectRaw("id, first_name, last_name, company_group_id")
            ;
    }
}
