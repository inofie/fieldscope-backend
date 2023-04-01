<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
    protected $table = "category";

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /** 1:required |2:damaged (aka: inspection area) |3:additional */

    public static function create($company)
    {
        $name = $company['first_name'];
        if (!empty($company['last_name']))
            $name .= $company['last_name'];

        $obj = new static();

        $obj->title = $name;
        $obj->image_url = $company['image_url'];
        $obj->primary_user_id = $company['primary_user_id'];
        //$obj->website           = $company['website'];
        //$obj->description       = $company['description'];

        $obj->save();

        return $obj->id;
    }

    public static function getById($id)
    {
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getCategoryList($param)
    {
//        die('aa');
        $query = self::select();
//         $query->join('company AS co', 'co.id', 'category.company_id');
        //$query->join('company_group_category AS cgc', 'cgc.category_id', 'category.id');

        $query->where('category.type', '<>','3');

//         if(!empty($param['company_group_id']))
//             $query->where('cgc.company_group_id', $param['company_group_id']);

        if(isset($param['company_id']))
            $query->where('category.company_id', $param['company_id']);

        if(isset($param['type']))
            $query->where('category.type', $param['type']);

        if(isset($param['parent_id']))
            $query->where('category.parent_id', $param['parent_id']);

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
//            $query->where(function ($where) use($keyword){
//                $where->orWhere('category.name' ,'LIKE',      "'%$keyword%'");
//                $where->orWhere('min_quantity' ,'LIKE',     "'%$keyword%'");
//            });
        }
        $query->selectRaw(
            'category.id,
            category.name,
            category.company_id,
            category.type,
            
            category.parent_id,
            category.min_quantity,
            category.created_at,
            category.updated_at,
            category.deleted_at'
        );

        $query->orderBy('category.id','DESC');
        if(!empty($param['paginate'])){
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }
        return $query->get();
    }

    public static function getCategoryList_withGroupedCompanyGroup($param)
    {
        $query = self::select();
        //INNER JOIN company_group_category cgc ON cgc.`category_id` = c.`id`
        $query->join('company_group_category AS cgc','cgc.category_id','=','category.id');
        //INNER JOIN company_group` cg ON cg.id = cgc.`company_group_id`
        $query->join('company_group AS cg','cg.id','=','cgc.company_group_id');

        $query->where('category.parent_id', $param['parent_id']);
        $query->where('category.company_id', $param['company_id']);
        $query->where('category.type', $param['type']);

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->whereRaw("(
            `category`.`name` LIKE '%$keyword%' 
            OR `min_quantity` LIKE '%$keyword%' 
            OR cg.title LIKE '%$keyword%')");
//            $query->where(function ($where) use($keyword){
//                $where->orWhere('category.name' ,'LIKE',      "'%$keyword%'");
//                $where->orWhere('min_quantity' ,'LIKE',     "'%$keyword%'");
//            });
        }
        $query->selectRaw(
            "category.id,
            category.name,
            category.company_id,
            category.type,            
            category.parent_id,
            category.min_quantity,
            category.created_at,
            category.updated_at,
            category.deleted_at,
            GROUP_CONCAT(cg.title SEPARATOR ', ') company_group_titles
            "
        );

        $query->groupBy('category.id');
        $query->orderBy('category.id','DESC');
        if (!empty($param['paginate'])) {
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }
        return $query->get();
    }

    public static function areaDatatable($param = [])
    {
        $output = [];
        parse_str($param['custom_search'], $output);

//        $query = self::select();

        $query = self::leftJoin('company_group_category AS cgc','cgc.category_id','=','category.id');
        $query->leftJoin('company_group AS cg','cg.id','=','cgc.company_group_id');

        $query->where('category.parent_id', $param['parent_id']);
        $query->where('category.company_id', $param['company_id']);
        $query->where('category.type', $param['type']);

        $sort = [
            'category.name',
            'category.type',
            'company_group_titles'
        ];
        // select *,category.id,category.name,category.thumbnail,category.company_id,category.type,category.order_by,category.parent_id,category.min_quantity,category.created_at,category.updated_at,category.deleted_at,GROUP_CONCAT(cg.title SEPARATOR ', ') company_group_titles from `category` inner join `company_group_category` as `cgc` on `cgc`.`category_id` = `category`.`id` inner join `company_group` as `cg` on `cg`.`id` = `cgc`.`company_group_id` where `category`.`parent_id` = 0 and `category`.`company_id` = 1 and `category`.`typea` = 2 and `category`.`deleted_at` is null group by `category`.`id`
        $query->select(
            'category.id',
            'category.name',
            'category.thumbnail',
            'category.company_id',
            'category.type',
            'category.order_by',
            'category.parent_id',
            'category.min_quantity',
            'category.created_at',
            'category.updated_at',
            'category.deleted_at',
            \DB::raw( "GROUP_CONCAT(cg.title SEPARATOR ', ') company_group_titles" ));

        /*
            GROUP_CONCAT(cg.title SEPARATOR ', ') company_group_titles
         * */

        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->whereRaw("(
            `category`.`name` LIKE '%$keyword%' 
            OR `min_quantity` LIKE '%$keyword%' 
            OR cg.title LIKE '%$keyword%')");
        }

        $query->groupBy('category.id','category.name',
            'category.thumbnail',
            'category.company_id',
            'category.type',
            'category.order_by',
            'category.parent_id',
            'category.min_quantity',
            'category.created_at',
            'category.updated_at',
            'category.deleted_at');


        /** There's a known issue in framework that you can't do count() records after groupBy (as below) Ref: https://stackoverflow.com/a/74300300/4308270
         *  $data['total_record'] = $query->count();
         *  We need to sub-query in from and then count the returned data-set you could do it the ref-link comment has mentioned
         *  But, since fromSub() is added in 5.8 we had to resort to the below code to work-around the situation
         */

        /** Useful For below solution
         *  Mind that you need to merge bindings in correct order. If you have other bound clauses, you must put them after mergeBindings: Ref: https://stackoverflow.com/a/24838367/4308270
         */
        $data['total_record'] = \DB::table(\DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query->getQuery()) // you need to get underlying Query Builder
            ->count();

//        $param['column_index'] = empty($sort[$param['column_index']]) ? 0 : $param['column_index'];
        // ->orderBy($sort[$param['column_index']],$param['sort'])
        $query = $query->take($param['length'])->skip($param['start'])->orderBy('order_by','ASC');

        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function photoViewDatatable($param = []){
        $output = [];
        parse_str($param['custom_search'], $output);

        $sort = [
            'category.name',
            'c1.name',
            'category.min_quantity'
        ];

        $query = self::select(  'c1.id AS category1_id',
                                'c1.name AS category1_name',
                                'c1.min_quantity AS category1_min_quantity',
                                'c1.type AS category1_type',
                                'category.type AS category2_type',
                                'category.id AS category2_id',
                                'category.name AS category2_name',
                                'category.thumbnail AS category2_thumbnail',
                                'category.min_quantity AS category2_min_quantity',
                                'category.order_by',
                                'category.parent_id AS category2_parent_id');

        $query->leftJoin('category AS c1','c1.id','category.parent_id');
        $query->join('company_group_category AS cgc','cgc.category_id','=','category.id');

        $query->where('c1.company_id',$param['company_id']);
//        $query->where('company_group_category.company_group_id',$param['company_group_id']);

        if(!empty($param['parent_id'])){
            $query->where('c2.parent_id',$param['parent_id']);
        }

        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];

            $query->whereRaw("(
            c1.name LIKE '%$keyword%' 
            OR category.min_quantity LIKE '%$keyword%' 
            OR category.name LIKE '%$keyword%')");
        }

        $data['total_record'] = $query->count();

        $query = $query->take($param['length'])->skip($param['start'])->orderBy('order_by','ASC');

        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function getCategory_withCompanyGroup($param)
    {
        $query = self::select();
        //INNER JOIN company_group_category cgc ON cgc.`category_id` = c.`id`
        $query->leftJoin('company_group_category AS cgc','cgc.category_id','=','category.id');


        if(!empty($param['category_id']))
            $query->where('category.id', $param['category_id']);
        //$query->where('category.parent_id', $param['parent_id']);
        if(!empty($param['company_id']))
            $query->where('category.company_id', $param['company_id']);

        $query->selectRaw(
            "category.id,
            category.name,
            category.company_id,
            category.type,
            category.parent_id,
            category.min_quantity,
            cgc.company_group_id,
            category.created_at,
            category.updated_at,
            category.deleted_at
            "
        );

        return $query->get();
    }

    public static function getSubCategory_withParents($param){


        $query = self::select('c1.id AS category1_id','c1.name AS category1_name','c1.min_quantity AS category1_min_quantity',
            'c1.type AS category1_type', 'category.type AS category2_type', 'category.id AS category2_id','category.name AS category2_name',
            'category.min_quantity AS category2_min_quantity','category.parent_id AS category2_parent_id');

        $query->leftJoin('category AS c1','c1.id','category.parent_id');

        $query->where('c1.company_id',$param['company_id']);
//        $query->where('company_group_category.company_group_id',$param['company_group_id']);

        if(!empty($param['parent_id'])){
            $query->where('c2.parent_id',$param['parent_id']);
        }

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->whereRaw("(
            c1.name LIKE '%$keyword%' 
            OR category.min_quantity LIKE '%$keyword%' 
            OR category.name LIKE '%$keyword%')");
        }

        $data['total_record'] = count(((array) $query->get()));

        $query->orderBy('category.id','DESC');
        if($param['paginate']){
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }
        return $query->get();

    }

    public static function getAllCategoryList($where)
    {
        $query = self::with('getChild')->where('parent_id',0);
//        $query->join('company AS co','co.id','category.company_id');
//        $query->where('category.id', 1);
        return $query->get();
    }

    public static function getCategoryByCompanyGroup($param)
    {
        $query = self::with('children')->where('parent_id',0);

        $query->join('company_group_category AS cgc'
            ,'cgc.category_id','=' , 'category.id');

        $query->where('cgc.company_id',$param['company_id']);
        $query->where('cgc.company_group_id',$param['company_group_id']);

//        $query->join('company AS co','co.id','category.company_id');
//        $query->where('category.id', 1);

        return $query->get();
    }

    public static function storeCompanyGroupCategory($request)
    {
        return \DB::table('company_group_category')->insertGetId([]);
    }

    public static function getCategoriesForReport($request){

        $categories = self::getCategoryListByType($request);

        dd($categories,'getCategoriesForReport > $categories');

        foreach ($categories['required_category'] AS $key => $item){
            $options[] =  [
                'id' => $item['id'],
                'title' => $item['category_name'],
                'estimates' => [
                    'selected' => FALSE,
                    'cost_breakdown' => [
                        'uom' => FALSE,
                        'material_cost' => FALSE,
                        'labor_cost' => FALSE,
                        'equipment_cost' => FALSE,
                        'supervision_cost' => FALSE,
                        'margin' => FALSE,
                        'sales_tax' => FALSE,
                    ]
                ],
                'has_estimates' => TRUE,
                'is_selected' => FALSE,

            ];
        }

        foreach ($categories['damaged_category'] AS $key => $item){

            // $catQuery = Query::where(['category_id' => $item['id'] ])->count();
            $options[] =  [
                'id' => $item['id'],
                'title' => $item['category_name'],
                'has_survey' => $item['has_survey'],
                'survey' => FALSE,
                'estimates' => [
                    'selected' => FALSE,
                    'cost_breakdown' => [
                        'uom' => FALSE,
                        'material_cost' => FALSE,
                        'labor_cost' => FALSE,
                        'equipment_cost' => FALSE,
                        'supervision_cost' => FALSE,
                        'margin' => FALSE,
                        'sales_tax' => FALSE,
                    ]
                ],
                'has_estimates' => TRUE,
                'is_selected' => FALSE,
            ];
        }

        /*additional_photos*/
        foreach ($categories['additional_photos'] AS $key => $item){
            // $catQuery = Query::where(['category_id' => $categories['additional_photos']['id']])->count();
            $options[] = [
                'id' => $item['id'],
                'title' => $item['category_name'],
                'has_survey' => $item['has_survey'],
                'survey' => FALSE,
                'is_selected' => FALSE
            ];
        }

        pd(json_encode($options),'$options');

        return $options;
    }

    public static function getCategoryListByType($param){
        $relation = ['getChild' ,
            'category_survey'
        ];

        $query = Category::with($relation)
            ->selectRaw("category.id AS id,category.type AS type,category.company_id AS company_id, category.name AS category_name , category.min_quantity AS category_min_quantity,
        category.type AS category_type, NULL AS media, category.id AS category_id");

//        $query->selectRaw('IF( ( SELECT COUNT(id) FROM category c WHERE c.parent_id = cgc.category_id ) > 0 , "yes" , "no" ) AS has_child');

        $query->where('category.company_id', $param['company_id']);
//
//        if(!empty($param['company_group_id'])){
//
//            $query->join('company_group_category AS cgc', function ($join) {
//                $join->on('category.id', '=', 'cgc.category_id')->where('category.parent_id', '=', 0);
//            });
//            $query->where('cgc.company_group_id', $param['company_group_id']);
//        }

        $query->whereNull('category.deleted_at');

        if (!empty($param['category_id'])) {
            if(is_array($param['category_id'])){
                $query->whereIn('category.id', $param['category_id']);
            } else {
                $query->where('category.id', $param['category_id']);
            }
        }

        $query->orderBy('order_by','ASC');

        $category = [
            'required_category' => [],
            'damaged_category' => [],
            'additional_photos' => []
        ];

        dd($query->get()->toArray());

        foreach ($query->get()->toArray() AS $key => $item) {
            if ($item['type'] == 1) {
                $category['required_category'][] = $item;
            } else if ($item['type'] == 3) {
                $category['additional_photos'][] = $item;
            } else {
                if(!empty($item['category_survey'])){
                    $item['survey'] =  count(((array) $item['category_survey'])) > 0 ?  true : false;
                    $item['has_survey'] =  count(((array) $item['category_survey'])) > 0 ?  true : false;
                }

                $category['damaged_category'][] = $item;
            }
        }

        return $category;

//        pd($category,'$category');
//
//        $query->get()->toArray();
//
//        if($byType){
//            return self::parsingForCategoryType_AndSurveyOptions($query->get()->toArray());
//        }else{
//            return $results = $query->get()->toArray();
//        }
    }

    public static function getCategoryCompleteInformation($categories){
        $parDamCats = [];
        $dSubCatIds = [];
        $dCatsIds = [];

        foreach ($categories as $key => $item) {       /*Parsing PK based index + Setting $subCatIds*/
            $parDamCats[$item['id']] = $item;
            $parDamSubCats = [];
            $dCatsIds[] = $item['id'];                              /*Getting Main Cat Ids (For Tags)*/
            $dCatMinQty = $item['category_min_quantity'];
            foreach ($item['get_child'] as $key2 => $item2) {
                $item2['media'] = [];
//                $dCatMinQty += $item2['min_quantity'];
                $parDamSubCats[$item2['id']] = $item2;              /* Setting PK based index of SubCat */
                $dSubCatIds[] = $item2['id'];                       /*Getting Sub Ids (For Tags)*/
            }
            $parDamCats[$item['id']]['category_min_quantity'] = $dCatMinQty;
            $parDamCats[$item['id']]['get_child'] = $parDamSubCats; /* Setting PK based index of SubCat to Cat*/
        }
    }

    public static function reOrder($reOrderParam, $companyId, $start = 0){
//        echo '<pre>'; print_r($reOrderParam); exit;
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

    public static function deleteArea_withChild($id){

        $res = \DB::transaction(function () use($id ){
            \DB::table('category')->where('id',$id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            \DB::table('category')->where('parent_id',$id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        });

        if(is_null($res)){
            return true;
        }
        return false;
    }

    public static function getCompanyPhotoView($params){

        return self::where([ 'type' => $params['type'], 'company_id' => $params['company_id'] ])
            ->where('parent_id','<>','0');
    }

    public static function getCompanyCategories($params){

        return self::where(['company_id' => $params['company_id'] ])->get();
    }

    public function getCompanyGroupCategories($params){

        return self::
            select('category.id','category.name','category.type')
            ->join("company_group_category AS cgc",'cgc.category_id','category.id')
            ->where(['category.company_id' => $params['company_id'], 'cgc.company_group_id' => $params['company_group_id'], 'category.parent_id' => 0])
            ->get();
    }

    public function scopeWithTagsAndEvFields($q){
        return $q->with(['category_tags' => function($q){
            $q->join('ev_product_fields AS epf','epf.primary_product_id','tag.ev_primary_product_id');
            $q->select(
//            'epf.primary_product_id',
            'ref_id',
//            'ref_type',
            'tag.name',
//            'tag.id',
//            'tag.has_qty',
//            'tag.is_required',
//            'tag.price',
//            'tag.spec_type',
//            'tag.build_spec',
            'tag.ev_primary_product_id',
            'tag.ev_product_field_id',
            'epf.name AS ev_field_name'
            );

        }]);
    }

    public function scopeWithTagsAndHoverFields($q){
        return $q->with(['category_tags' => function($q){
            $q->join('hover_fields AS hf','hf.id','=','tag.hover_field_id');
            $q->join('hover_field_types AS hft','hft.id','hf.hover_type_id');
//            $q->where('tag.hover_field_type_id','>',0);
            $q->select(
                'tag.id',
                'tag.company_id',
                'tag.name',
                'tag.ref_id',
                'tag.has_qty',
                'tag.is_required',
//                'tag.price',
//                'tag.spec_type',
//                'tag.build_spec',
                'tag.hover_field_type_id',
                'tag.hover_field_id',
                'hft.slug AS field_type_slug',
                'hf.name AS hover_field_name',
                'hf.method AS method',
                'hf.config_path AS config_path',
                'hf.params AS params'
            );

        }]);
    }

    //<editor-fold desc="Relation Starts">
    public function media(){
        $this->hasMany('App\Models\ProjectMedia','category_id','id');
    }

    public function getChild()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with(['category_tags' => function ($q) {
            $q->leftJoin('uoms AS sub_u', 'sub_u.id', '=', 'tag.uom_id')->selectRaw('tag.*')->addSelect('sub_u.title AS uom'); 
        }])->orderBy('order_by','ASC');
    }

    public function category_tags()
    {
        return $this->hasMany('App\Models\Tag', 'ref_id', 'id')->where('ref_type','=', 'category')
            ->leftJoin('uoms AS u','u.id','=' ,'tag.uom_id' )->selectRaw('tag.*')->addSelect('u.title AS uom');
    }

    public function category_survey (){
        return $this->hasMany('App\Models\Query', 'category_id', 'id')->whereNull('deleted_at')
            ->selectRaw('*,NULL AS user_response')->orderBy('order_by','ASC');
    }

    public function getParent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->getChild()->with('children');
    }
    //</editor-fold>

}
