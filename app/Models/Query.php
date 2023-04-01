<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use App\Models\QueryTag;

use App\Libraries\Helper;

class Query extends Model
{
    protected $table = "query";
    protected $fillable = ['company_id', 'query', 'type', 'category_id', 'options', 'photo_view_id','is_required', 'custom_tag', 'created_at' ,'order_by', 'image_url'];

    use SoftDeletes;

    public static function getList($param)
    {
        $query = self::select();
        $query->where('company_id', $param['company_id']);

        if (!empty($param['keyword'])) {
            //echo "AAA";die;
            $keyword = $param['keyword'];
//            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('query', 'LIKE', "%$keyword%");
            });
        }
//        print_r($query->get());

        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function queryDatatable($param = []){
        $output = [];
        parse_str($param['custom_search'], $output);

        $sort = [
            'query'
        ];

        $query = self::join('category AS c','c.id','=','query.category_id')->selectRaw('query.*,c.name AS category_name');

        $query->where('query.company_id', $param['company_id']);

        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('query', 'LIKE', "%$keyword%");
                $where->orWhere('c.name', 'LIKE', "%$keyword%");
            });
        }

        $data['total_record'] = count($query->get());
        $query = $query->take($param['length'])->skip($param['start'])->orderBy('order_by','ASC');



        $query = $query->get();
//        Helper::pd($query->get()->toArray(),'$query');
        $data['records'] = $query;
        return $data;
    }

    public static function getByCategoryId($id,$param = []){
        /*working late*/
        $query = self::select();
        $data = $query->where('id', $id)->first();

        $query = self::select();

        $query->where('category_id', $data['category_id']);

        if (!empty($param['orderBy'])) {
            $query->orderBy($param['orderBy'][0], $param['orderBy'][1]);
        }

        $category = $query->get();
        return $category;
    }

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getAllBy($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getWithUserResponse($param)
    {
//        print_r($param); die;
        $query = self::with(['userResponse' => function ($query) use ($param) {
            $query->where('query_id', $param['id']);
        }])->select();

        if (!empty($param['id'])) {
            $query->where('id', $param['id']);
        }

        return $query->get();
    }

    public static function updateQuery($request){
        $question = $request['question'];
        $queryId = $request['query_id'];
        $type = $request['type'];
        $orderBy = $request['order_by'];
        $options =   $request['options'];
        $photo_view =   $request['photo_view'];
        $image_set =   $request['image_set'];


                $queryUpdateData = [];

                if ($request->file('help_photo')) {
                    $queryUpdateData['image_url'] =
                        Helper::uploadFile($request->file('help_photo'), 'sample_query', Config::get('constants.MEDIA_IMAGE_PATH'));
                }else if ($image_set == 'false') {
                    \Log::debug('image else '.$image_set);
                    $queryUpdateData['image_url'] = "";
                }

                $queryUpdateData['company_id'] = $request['company_id'];
                $queryUpdateData['is_required'] = filter_var($request['is_required'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
                $queryUpdateData['query'] = $question;
                $queryUpdateData['type'] = $type;
                $queryUpdateData['updated_at'] = date('Y-m-d H:i:s');


                if (!empty($options) && ($type == 'text' || $type == 'date' || $type == 'sign')) {
                    $queryUpdateData['options'] = '';
                } else {
                    /**
                     * IF checkbox or radio
                     */
                    if (in_array('N/A', $options)) {
                        $queryUpdateData['photo_view_id'] = !empty($photo_view) ? $photo_view : NULL;
                    }

//                    if (!empty($naRule[$key])) {
//                        /** IF NA is selected */
//
//
//                    } else {
//
//                        /** IF NA is not selected
//                         *      -> Need to remove NA if exists in options
//                         */
//                        $queryUpdateData['photo_view_id'] = NULL;
//
//                        if (in_array('N/A', $option[$key])) {
//                            /** N.A is IN request options
//                             *      -> Must remove it (cuz NA wasn't selected) *
//                             */
//                            if (($optionKey = array_search('N/A', $option[$key])) !== false) {
//                                unset($option[$key][$optionKey]);
//                            }
//                        }
//                    }
                    $queryUpdateData['options'] = trim(implode(',', $options), ' ,');

                    if(empty($queryUpdateData['options'])){
                        return ['error' => 'Required Options Missing at question.'];
                    }
                }
                \Log::debug('is_required data: '.print_r([!empty($request['is_required'])] , 1));
                \Log::debug('request data: '.print_r($request->all() , 1));
                \Log::debug('update data: '.print_r($queryUpdateData , 1));

                $qResult = self::where(['id' => $queryId])->update($queryUpdateData);


        return $qResult;
    }

    public static function deleteQuery($id){
        return self::where('id',$id)->delete();
    }

    public static function parseSurvey($survey)
    {
//        die("$survey");
        $parsedArr = [];
        foreach ($survey AS $key => $item) {

            if(!empty($item['image_url'])){
                $item['image_url'] = env('BASE_URL').config('constants.MEDIA_IMAGE_PATH').$item['image_url'];
            }
            if($item['type'] == 'text' || $item['type'] == 'date' || $item['type'] == 'sign' ){
                $item['options'] = [];
            }
            else{
                /*Checkbox , Radio*/
//                $item['options'] = 'N/A,' . $item['options'];
                $opExp = explode(',', $item['options']);
                $options_data = [];
                foreach ($opExp AS $opKey => $opItem) {
                    $options_data[] = [
                        'title' => $opItem,
                        'is_selected' => false
                    ];
                }
                $item['options'] = $options_data;

                if (in_array('N/A',$opExp)) {
                    $item['has_na'] = TRUE;
                }else{
                    $item['has_na'] = FALSE;
                }
            }
            $parsedArr[$key] = $item;
        }
        return $parsedArr;
    }

    public static function reOrder($reOrderParam, $companyId, $start = 0){
//        echo '<pre>'; print_r($reOrderParam); exit;
        foreach ($reOrderParam AS $key => $item){
            $res = self::where('id',$item['id'] )->update(['order_by' => ($start ) + ($item['new_position']+1)]);
            /*echo "update `category` set `order_by` = ".((($start ) + ($item['new_position']+1)) ).",
            `updated_at` = 2019-08-29 11:26:37 where `id` = ".$item['id']." and `category`.`deleted_at` is null)\n";*/
            if(empty($res)){
                /*Failed*/
                return ['error' => 'Error in updating at '.$key ];
            }
        }
        return true;
    }

    /*Relations Starts*/

    public function userResponse(){
        return self::hasMany('App\Models\ProjectQuery', 'query_id');
    }

    public function tags(){
        return $this->hasMany('App\Models\Tag', 'ref_id', 'id')->where('ref_type','=', 'query');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
