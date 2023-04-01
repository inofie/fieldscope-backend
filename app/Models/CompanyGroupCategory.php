<?php

namespace App\Models;

use App\Libraries\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class CompanyGroupCategory extends Model
{
    protected $table = "company_group_category";

    protected $fillable = [
        'company_id',
        'category_id',
        'company_group_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function getByCompanyId($id)
    {
        $query = self::select();
        return $query->where('company_id', $id)
            ->first();
    }

    public static function getCompanyGroupList($param)
    {
        $query = self::select();

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $orWhere = [
                ['id', 'LIKE', "%$keyword%"],
                ['title', 'LIKE', "%$keyword%"],
            ];
            foreach ($orWhere AS $item) {
                $query->orWhere([$item]);
            }
        }
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getCategoriesForReport($request){

        $categories = self::getCategories($request,TRUE);

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

            $catQuery = Query::where(['category_id' => $item['id'] ])->count();
            $options[] =  [
                'id' => $item['id'],
                'title' => $item['category_name'],
                'has_survey' => ($catQuery > 0) ? TRUE : FALSE,
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
        $catQuery = Query::where(['category_id' => $categories['additional_photos']['id']])->count();
        $options[] = [
            'id' => $categories['additional_photos']['id'],
            'title' => $categories['additional_photos']['category_name'],
            'has_survey' => ($catQuery > 0) ? TRUE : FALSE,
            'survey' => FALSE,
            'is_selected' => FALSE
        ];

        return $options;
    }

    public static function getByCategoryId($param)
    {

        $query = self::selectRaw('c.id,cg.id cg_id, company_group_category.company_id, cg.title AS user_group_title, 
        c.name AS name,c.thumbnail AS thumbnail, c.parent_id, c.min_quantity')
            ->join('company_group AS cg', 'cg.id', '=', 'company_group_category.company_group_id')
            ->join('category AS c', 'c.id', '=', 'company_group_category.category_id')
            ->where('company_group_category.company_id', $param['company_id'])
            ->where('c.id', $param['category_id']);
        $data = $query->get();
        return $data;
    }

    public static function getCategories($param, $byType = FALSE)
    {
        $relation = ['getChild' ,
            'category_tags',
            'category_survey.tags'
        ];

        $query = Category::with($relation)
            ->selectRaw("category.id AS id,category.company_id AS company_id, category.name AS category_name , 
            category.min_quantity AS category_min_quantity,category.type AS category_type, NULL AS media, 
            category.id AS category_id");

        $query->selectRaw('IF( ( SELECT COUNT(id) FROM category c WHERE c.parent_id = cgc.category_id ) > 0 , "yes" , "no" ) AS has_child');

        $query->join('company_group_category AS cgc', function ($join) {
            $join->on('category.id', '=', 'cgc.category_id')->where('category.parent_id', '=', 0);
        });

        $query->where('cgc.company_group_id', $param['company_group_id']);

        $query->where('cgc.company_id', $param['company_id']);

        $query->whereNull('category.deleted_at');

        if (!empty($param['category_id'])) {
            if(is_array($param['category_id'])){
                $query->whereIn('category.id', $param['category_id']);
            } else {
                $query->where('category.id', $param['category_id']);
            }
        }

        $query->orderBy('order_by','ASC');
//        dd('$query->get()->toArray()',$byType,getRawQuery($query));

        if($byType){
            $parsed = self::parsingForCategoryType_AndSurveyOptions($query->get()->toArray());
//            dump($param,$query->get()->toArray(),'parsingForCategoryType_AndSurveyOptions',$parsed);
            return $parsed;
        }else{
            return $results = $query->get()->toArray();
        }
    }

    public static function getCategories_bk($param, $byType = FALSE)
    {

        $relation = ['getChild' ,
            'category_tags',
            'category_survey.tags'
        ];
        $query = Category::with($relation)
            ->selectRaw("category.id AS id, category.name AS category_name , category.min_quantity AS category_min_quantity,
        category.type AS category_type, NULL AS media, category.id AS category_id");

        $query->selectRaw('IF( ( SELECT COUNT(id) FROM category c WHERE c.parent_id = cgc.category_id ) > 0 , "yes" , "no" ) AS has_child');
        $query->join('company_group_category AS cgc', function ($join) {
            $join->on('category.id', '=', 'cgc.category_id')->where('category.parent_id', '=', 0);
        });

        $query->where('cgc.company_id', $param['company_id']);
        $query->where('cgc.company_group_id', $param['company_group_id']);
        $query->whereNull('category.deleted_at');

        if (!empty($param['category_id'])) {
            if(is_array($param['category_id'])){
                $query->whereIn('category.id', $param['category_id']);
            }else{
                $query->where('category.id', $param['category_id']);
            }
        }

        if($byType){
            return self::parsingForCategoryType_AndSurveyOptions($query->get()->toArray());
        }else{
            return $results = $query->get()->toArray();
        }
    }

    public static function parsingForCategoryType_AndSurveyOptions($categoryArr)
    {
        $response = [
            'required_category' => [],
            'damaged_category' => [],
            'additional_photos' => []
        ];
        /*dividing categories by type*/

        /* Main Cat*/
        foreach ($categoryArr as $catArrKey => $catArrItem) {
            $surveyTags = NULL ;

            if (isset($catArrItem['category_survey']) && !empty($catArrItem['category_survey'])) {
                /*Parsing Survey*/
                $catArrItem['category_survey'] = Query::parseSurvey($catArrItem['category_survey']);
                $surveyTags[$catArrItem['id']] = [];
                foreach($catArrItem['category_survey'] AS $surKey => $surItem){
                    if(!empty($surItem['tags'])){
                        $surveyTags[$catArrItem['id']] =  array_merge($surveyTags[$catArrItem['id']] , $surItem['tags'] ) ;
                    }
                }
            }

            $minQty = 0;
            if($catArrItem['category_type'] == 2){
                foreach ($catArrItem['get_child'] AS  $catChildKey => $catChildItem){
                    $catArrItem['get_child'][$catChildKey]['media'] = [];

                    if(!empty($catArrItem['get_child'][$catChildKey]['category_tags'])){
                        if(
                            isset($surveyTags[$catArrItem['get_child'][$catChildKey]['parent_id']])
                            && !empty($surveyTags[$catArrItem['get_child'][$catChildKey]['parent_id']])
                        ){
                            $catArrItem['get_child'][$catChildKey]['category_tags']
                                = array_merge($surveyTags[$catArrItem['get_child'][$catChildKey]['parent_id']],$catArrItem['get_child'][$catChildKey]['category_tags']);
                        }
                    }
                    $minQty += $catChildItem['min_quantity'];
                }
            }
            $catArrItem['media'] = [];

            /** 1:required|2:damaged|3:additional */

            if ($catArrItem['category_type'] == 1) {
                $response['required_category'][] = $catArrItem;
            } else if ($catArrItem['category_type'] == 3) {
                $response['additional_photos'][] = $catArrItem;
            } else {
                $catArrItem['category_min_quantity'] = $minQty;
                $response['damaged_category'][] = $catArrItem;
            }
        }
        $response['required_category'] = array_values($response['required_category']);
        $response['damaged_category'] = array_values($response['damaged_category']);
        $response['additional_photos'] = $response['additional_photos'][0];
        return $response;
    }

    public static function getChildMinQuantity($param)
    {
        $query = self::selectRaw(
//                    'c1.id AS category1_id',
//                    'c1.name AS category1_name',
//                    'c1.min_quantity AS category1_min_quantity',
//                    'c1.type AS category1_type',

//                    'c2.type AS category2_type',
//                    'c2.id AS category2_id',
//                    'c2.name AS category2_name',
//                    'SUM(`c2`.min_quantity) AS category2_min_quantity_count, c2.parent_id AS category2_parent_id'
            '`c2`.id,`c2`.min_quantity AS category2_min_quantity, c2.parent_id AS category2_parent_id'
        );

        $query->leftJoin('category AS c2', 'c2.id', 'company_group_category.category_id');
//        $query->leftJoin('category AS c1','c1.id','c2.parent_id');

        $query->where('c2.parent_id', '!=', 0);
        $query->where('c2.type', 1);
        $query->where('company_group_category.company_id', $param['company_id']);
        $query->where('company_group_category.company_group_id', $param['company_group_id']);
//        $query->groupBy('c2.parent_id');
        return $query->get()->toArray();
//        $data = $query->get()->toArray();
//        print_r($data); die;
    }

    public static function countByCompanyAndGroup($where){
        $query = self::select();
        return $query->where($where)->count();
    }

    public static function insertAdditionalCategory($companyId,$companyGroupId){

        $additionalCat = Category::where(['type'=> 3 , 'company_id' => $companyId])->first();

        $count = self::where(['company_id' => $companyId, 'company_group_id' => $companyGroupId, 'category_id' => $additionalCat->id])->count();

        if ($count > 1) {
            /*Assign Cat To Group*/
            $cgcData = [
                'company_id' => $companyId,
                'category_id' => $additionalCat->id,
                'company_group_id' => $companyGroupId ,
                'created_at' => date(config('constants.DATE_FORMAT'))

            ];
            return self::create($cgcData);

        } else {
            /*Add Category */
            $cData = [
                'name' => 'Additional Photos',
                'company_id' => $companyId,
                'type' => 3,
                'parent_id' => 0,
                'min_quantity' => 0,
                'created_at' => date(config('constants.DATE_FORMAT'))
            ];
            $insertedId = Category::insertGetId($cData);

            /*Assign Cat to group*/
            $cgcData = [
                'company_id' => $companyId,
                'category_id' => $insertedId ,
                'company_group_id' => $companyGroupId ,
                'created_at' => date(config('constants.DATE_FORMAT'))

            ];
            return self::create($cgcData);
        }
//        Helper::pd($count );
    }
}

