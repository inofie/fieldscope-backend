<?php

namespace App\Models;

use App\Libraries\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ProjectQuery extends Model
{
    protected $table = "project_query";

    public $survey = [];

    protected $fillable = [
        'project_id', 'query_id', 'query', 'response', 'created_at', 'updated_at', 'signature', 'date'
    ];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getByProjectId_bk($id){

        $query = self::select();
        return $query->where('project_id', $id)
            ->get();
    }

    public static function insertSurvey($survey,$projectId,$submittedAt ="",$signature_url="")
    {
        $pSurvey = [];
        foreach ($survey AS $key => $item) {
            $response = '';
            if($item['type'] == 'text' || $item['type'] == 'date'){
                $response = $item['user_response'];
            }
            else if($item['type'] == 'sign'){
                $image = $item['user_response'];  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'q-'.$item['id'] . "-" . time() . '_' . rand().'.'.'png';
                $response = $imageName;
                \File::put(Config::get('constants.MEDIA_IMAGE_PATH'). '/' . $imageName, base64_decode($image));
            }
            else{
                $selectedOp = [];
                foreach ($item['options'] AS $opKey => $opItem) {
                    if ($opItem['is_selected']) {
                        $selectedOp[] = $opItem['title'];
                    }
                }
                $response = implode(',',$selectedOp);
            }

//            $image = $project['categories']['damaged_category'][$key]['signature'];  // your base64 encoded
//            $image = str_replace('data:image/png;base64,', '', $image);
//            $image = str_replace(' ', '+', $image);
//            $imageName = $project['categories']['damaged_category'][$key]['id'] . "-" . time() . '_' . rand().'.'.'png';
//            \File::put(Config::get('constants.MEDIA_IMAGE_PATH'). '/' . $imageName, base64_decode($image));

            /*$pSurvey[$key]['date'] = $submittedAt;
            $pSurvey[$key]['signature'] = $signature_url;*/
            $pSurvey[$key]['query_id'] = $item['id'];
            $pSurvey[$key]['query'] = $item['query'];
            $pSurvey[$key]['response'] = $response;
            $pSurvey[$key]['project_id'] = $projectId;
            $pSurvey[$key]['created_at'] = date('Y-m-d H:i:s');
        }
//        Helper::pd($pSurvey,'$pSurvey');

        $res = self::insert($pSurvey);
        return self::getByProjectId($projectId);
    }

    public static function updateSurvey($survey,$projectId,$submittedAt="",$signature_url="")
    {
//        Helper::pd($survey,'$survey');
        $pSurvey = [];
        foreach ($survey AS $key => $item) {
            $response = '';
            if($item['type'] == 'text' || $item['type'] == 'date'){
                $response = $item['user_response'];
            }
            else if($item['type'] == 'sign'){
                $image = $item['user_response'];  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'q-'.$item['id'] . "-" . time() . '_' . rand().'.'.'png';
                $response = $imageName;
                \File::put(Config::get('constants.MEDIA_IMAGE_PATH'). '/' . $imageName, base64_decode($image));
            }
            else{
                $selectedOp = [];
                foreach ($item['options'] AS $opKey => $opItem) {
                    if ($opItem['is_selected']) {
                        $selectedOp[] = $opItem['title'];
                    }
                }
                $response = implode(',',$selectedOp);
//                if (empty($response)) {
//                    $res['error_data'] = $item;
//                    $res['error'] = 'Response field is empty';
//                    return $res;
//                }
            }

            /*$pSurvey[$key]['date'] = $submittedAt;
            $pSurvey[$key]['signature'] = $signature_url;*/

            $pSurvey['query'] = $item['query'];
            $pSurvey['response'] = $response;
            $pSurvey['created_at'] = date('Y-m-d H:i:s');

            $updateRes = self::updateOrCreate(['project_id' => $projectId , 'query_id' => $item['id'] ],$pSurvey);
            if (empty($updateRes)) {
                $res['error_data'] = [$pSurvey,['project_id' => $projectId , 'query_id' => $item['id'] ]];
                $res['error'] = 'Failed to update query id: '.$item['id'];
                return $res;
            }
        }
        return self::getByProjectId($projectId);

    }

    public static function getByProjectId($projectId){
        $queries = self::
            join('query AS q','q.id' , '=' ,'project_query.query_id')
            ->selectRaw('
            q.id,  
            q.company_id,  
            q.query,                        
            q.type,      
            q.category_id,  
            q.options,
            project_query.response AS response')->where('project_id',$projectId)
            ->get()->toArray();
        return self::parseSurvey($queries);
    }

    public static function parseSurvey($survey)
    {
        $parsedArr = [];
        foreach ($survey AS $key => $item) {
            $imagePath = env('BASE_URL').Config::get('constants.MEDIA_IMAGE_PATH');
            if(!empty($item['image_url'])){
                $item['image_url'] = $imagePath.$item['image_url'];
            }

            if ($item['type'] == 'text' || $item['type'] == 'date' ) {
                $item['options'] = [];
                $item['user_response'] = $item['response'];
            } else if ($item['type'] == 'sign') {
                $item['user_response'] = $imagePath.$item['response'];
            } else {
                /** Checkbox , Radio*/
//                $item['options'] = 'N/A,' . $item['options'];

                $options_data = [];

                if(is_array($item['options'])){
                    /** Fill Responded survey*/
                    foreach ($item['options'] AS $opKey => $opItem) {
                        $responseExploded = explode(',', $item['response']);

                        $item['options'][$opKey]['is_selected'] = in_array($opItem['title'], $responseExploded) ? true : false;
                    }
                    $item['user_response'] = "";

                }else{
                    /** Fill non-responded survey*/
                    $opExploded = explode(',', $item['options']);
                    foreach ($opExploded AS $opKey => $opItem) {
                        $responseExploded = explode(',', $item['response']);
                        $options_data[] = [
                            'title' => $opItem,
                            'is_selected' => in_array($opItem, $responseExploded) ? true : false
                        ];
                    }
                    if (in_array('N/A',$opExploded)) {
                        $item['has_na'] = TRUE;
                    }else{
                        $item['has_na'] = FALSE;
                    }

                    $item['user_response'] = "";
                    $item['options'] = $options_data;
                }
            }
            $parsedArr[$key] = $item;
        }

        return $parsedArr;
    }

    /*Relation Starts*/
    public function survey(){
        return $this->hasMany('App\Models\Query','query');
    }

}
