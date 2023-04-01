<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class Tag extends Model
{
    protected $table = "tag" , $fillable  = [
        'company_id', 'ref_id', 'ref_type', 'name', 'annotation', 'has_qty', 'is_required', 'price', 'created_at', 'updated_at', 'deleted_at', 'target_id'
    ];

    public $uom = ['SQFT', 'SQ','BDL','RL','EA','FT','BX','LFT','SET','QTY'];

    use SoftDeletes;

    public static function getList($param)
    {
        $query = self::select();
        $query->where('company_id', $param['company_id']);

        if(!empty($param['ref_id'])){
            $query->where(['ref_id', $param['ref_id'] , 'ref_type' => 'category'] );
        }

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
//            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
            });
        }
//        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        return $query->get();
    }

    public static function getById($id){
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public function getCompanyTags($param){

        $query = self::selectRaw(
            "tag.id,
            tag.name,
            tag.company_id,
            tag.has_qty,
            tag.created_at,
            c1.name AS c1_name,
            c2.name AS c2_name"
        );
        //INNER JOIN company_group_category cgc ON cgc.`ref_id` = c.`id`
        $query->join('category AS c2','c2.id','=','tag.ref_id');
        //INNER JOIN company_group` cg ON cg.id = cgc.`company_group_id`
        $query->join('category AS c1','c1.id','=','c2.parent_id');

        $query->where('tag.company_id', $param['company_id']);
        $query->where('c1.type', $param['type']);
        $query->where('tag.ref_type', 'category');

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->whereRaw("(
            `c2`.`name` LIKE '%$keyword%'
            OR `c1`.`name` LIKE '%$keyword%'
            OR tag.name LIKE '%$keyword%')");
        }

        $query->orderBy('tag.id','DESC');
        if (!empty($param['paginate'])) {
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }
        return $query->get();
    }

    public static function
    getTagsDatatable($params){
        $output = [];
        parse_str($params['custom_search'], $output);

//        Helper::p($output,'$output');
//        Helper::pd($params,'$params');

        $query = self::selectRaw('tag.*,c1.name AS c1_name');
        $query->join('category AS c1','c1.id','=','tag.ref_id');

        $query->where('tag.company_id', $params['company_id']);
        $query->where('c1.type', $params['type']);
        $query->where('tag.ref_type', 'category');
        $query->whereNull('c1.deleted_at');

        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->whereRaw("(
            `c1`.`name` LIKE '%$keyword%'
            OR tag.name LIKE '%$keyword%')");
        }

        $sortMap = [
            'tag.id',
            'tag.name',
            'tag.has_qty',
            'c1.name'
        ];

        $data['total_record'] = $query->count();

        // $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
        // ->orderBy($sortMap[$params['column_index']],$params['sort']);
        $query = $query->take($params['length'])->skip($params['start'])->orderBy('order_by','ASC');

        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function getReqTagsDatatable($params){
        $output = [];
        parse_str($params['custom_search'], $output);

//        Helper::p($output,'$output');
//        Helper::pd($params,'$params');

        $query = self::selectRaw('tag.*,c1.name AS c1_name');
        $query->join('category AS c1','c1.id','=','tag.ref_id');

        $query->where('tag.company_id', $params['company_id']);
        $query->where('c1.type', $params['type']);
        $query->where('tag.ref_type', 'category');
        $query->whereNull('c1.deleted_at');

        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->whereRaw("(
            `c1`.`name` LIKE '%$keyword%'
            OR tag.name LIKE '%$keyword%')");
        }

        $sortMap = [
            'tag.id',
            'tag.name',
            'tag.has_qty',
            'c1.name'
        ];

        $data['total_record'] = count($query->get());

        // $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
        // ->orderBy($sortMap[$params['column_index']],$params['sort']);
        $query = $query->take($params['length'])->skip($params['start'])->orderBy('order_by','ASC');

        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function reOrder($reOrderParam, $companyId, $start = 0){

        foreach ($reOrderParam AS $key => $item){
            $res = self::where('id',$item['id'] )->update(['order_by' => ($start ) + ($item['new_position'])]);
            //            Log::info('reOrder: ',['start' => $start , 'old_position' => $item['old_position'] , 'new_position' => $item['new_position'] ]);
            if(empty($res)){
                /*Failed*/
                return ['error' => 'Error in updating at '.$key ];
            }
        }
        return true;
    }

    public static function insertTag($tag){

        return self::insertGetId($tag);

    }

    public static function insertFromImportFile($fileData,$request){

        $insertData = [];
        $categoryIds = array_unique(array_column($fileData->toArray(),'category_id'));
        $cat = Category::whereIn('id',$categoryIds)->where(['type' =>  $request['type']])->get();

        if(count(((array) $cat)) < count(((array) $categoryIds))){
            return ['error' => 'Invalid category' ];
        }

        foreach ($fileData AS $key => $item) {

            if (empty($item['name']) || empty($item['category_id']) || empty($item['category_id'])) {
                return ['error' => 'Invalid data at row ' . ((int)$key + 2)];
            }
            // @formatter:off
            $insertData[] = [
                'company_id' => $request['company_id'],
                'ref_id' => $item['category_id'],
                'ref_type' => 'category',
                'name' => $item['name'],
                'annotation' => $item['annotation'],
                'has_qty' =>     (strtolower($item['has_qty']) == 'yes')? 1 : 0,
                'is_required' => (strtolower($item['is_required']) == 'yes')? 1 : 0,
                'price' =>       !empty($item['price']) ? $item['price'] : 0 ,
                'spec_type'   => $item['spec_type'] ,
                'build_spec'  => $item['build_spec'] ,

                'uom_id' =>               $item['uom_id'] ?: null,
                'material_cost' =>        $item['material_cost'] ?: null,
                'labor_cost' =>           $item['labor_cost'] ?: null,
                'equipment_cost' =>       $item['equipment_cost'] ?: null,
                'supervision_cost' =>     $item['supervision_cost'] ?: null,
                'margin' =>               $item['margin'] ?: null,
                'hover_field_type_id' =>  !empty($item['hover_field_type_id']) ? $item['hover_field_type_id'] : 0,
                'hover_field_id' =>       !empty($item['hover_field_id']) ? $item['hover_field_id'] : 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            // @formatter:on
        }
        return self::insert($insertData);
    }

    public static function getCompanyHoverFields($params){

        $q = self::select();

        $q->join('hover_fields AS hf','hf.id','=','tag.hover_field_id');
        $q->join('hover_field_types AS hft','hft.id','hf.hover_type_id');
        $q->where('tag.company_id',$params['company_id']);
        $q->select(

            'tag.id',
            'tag.company_id',
            'tag.name',
            'tag.ref_id',
            'tag.has_qty',
            'tag.is_required',
//                'tag.price',
//                'tag.spec_type',
//                'tag.build_spec',bhgz.xs.xdx,
            'tag.hover_field_type_id',
            'tag.hover_field_id',
            'hft.slug AS field_type_slug',
            'hf.name AS hover_field_name',
            'hf.method AS method',
            'hf.config_path AS config_path',
            'hf.params AS params'
        );

        return $q->get();

    }

    /** Finding the categories that have tags with price > 0*/
    public static function getTagsCount_byCost($params){
        $q = self::selectRaw('COUNT(tag.id) AS price_count')->withCategory();

        $q->where(['tag.company_id' => $params['company_id']]);
        $q->where('c.type','<>','3');
        $q->where('tag.price','>','0');

        $q->groupBy('parent_id','category_id');
        // $q->having('tag.price', '>', 0);
        $q->orderBy('tag.price','asc');

        $q->get();
    }

    public static function scopeWithCategory($q, $categoryId = null, $categoryLevel = 'child')
    {
        $q->join('category AS c', function ($join) {
            $join->on('c.id', '=', 'tag.ref_id')->on('tag.ref_type', '=', \DB::raw("'category'"));
        });
        $q->leftJoin('category AS parent','parent.id','=','c.parent_id');
        $q->addSelect('c.id AS category_id','c.name AS category_name','c.type AS category_type','parent.id AS parent_id','parent.name AS parent_name');

        if(!empty($categoryId)){
            if ($categoryLevel == 'child') {
                $q->where('c.id', $categoryId);
            } else if ($categoryLevel == 'parent') {
                $q->where('c.parent_id', $categoryId);
            }
        }

        return $q;
    }


//    public static function getCompanyReqTags($param){
//        $query = self::select();
//        //INNER JOIN company_group_category cgc ON cgc.`ref_id` = c.`id`
//
//        //INNER JOIN company_group` cg ON cg.id = cgc.`company_group_id`
//        $query->join('category AS c1','c1.id','=','tag.ref_id');
//
//        $query->where('tag.company_id', $param['company_id']);
//        $query->where('c1.type', $param['type']);
//        $query->where('tag.ref_type', 'category');
//
//        if (!empty($param['keyword'])) {
//            $keyword = $param['keyword'];
//            $query->whereRaw("(
//            `c1`.`name` LIKE '%$keyword%'
//            OR tag.name LIKE '%$keyword%')");
//        }
//
//        $query->selectRaw(
//            "tag.id,
//            tag.name,
//            tag.company_id,
//            tag.has_qty,
//            tag.created_at,
//            c1.name AS c1_name"
//        );
//
//
//        $query->orderBy('tag.id','DESC');
//        if (!empty($param['paginate'])) {
//            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
//        }
//        return $query->get();
//    }

//    public static function getByCategoryId($id)
//    {
//        $query = self::select();
//        return $query->where(['ref_id' => $id , 'ref_type' => 'category'])->get();
//    }
//
//    public static function getByQueryId($id)
//    {
//        $query = self::select();
//        return $query->where(['ref_id' => $id , 'ref_type' => 'query'])->get();
//    }

    //<editor-fold desc="Relation Start">
    public function getCategories (){
        return $this->belongsTo('App\Models\Category','ref_id','id')->where('ref_type', 'category');
    }

    public function tags(){
        return $this->belongsTo('App\Models\HoverField','hover_field_id' , 'id')
            ->where('tag.hover_field_type_id','hover_field.hover_type_id');
    }

    public function tagUom(){
        return $this->belongsTo('App\Models\Uom','uom_id' , 'id')
            ;
    }

    //</editor-fold>

}
