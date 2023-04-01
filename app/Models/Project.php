<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Project extends Model
{
    protected $table = "project";
    protected  $dates = ['inspection_date','created_at','updated_at','deleted_at'];

    use SoftDeletes,GeneralModelTrait;

    public static function storeDetails($project , $userDetails){

        $insert['company_id']       = $userDetails['company_id'];
        $insert['name']             = $project['name'];
        $insert['address1']         = $project['address1'];
        $insert['address2']         = $project['address2'];
        $insert['state_id']         = $project['state_id'];
        $insert['city_id']          = $project['city_id'];
        $insert['postal_code']      = $project['postal_code'];
        $insert['claim_num']        = $project['claim_num'];
        $insert['sales_tax']        = $project['sales_tax'];
        $insert['inspection_date']  = $project['inspection_date'];
        $insert['latitude']         = $project['latitude'];
        $insert['longitude']        = $project['longitude'];
        $insert['customer_email']   = $project['customer_email'];
        $insert['ref_id']           = $project['id'];
        $insert['crm_project_id']   = $project['crm_project_id'];
        $insert['assigned_user_id'] = $userDetails['user_id'];
        $insert['user_id']          = $userDetails['user_id'];
        $insert['status_id']        = $project['status_id'];
        $insert['project_status']   = $project['project_status'];
        $insert['created_at']  = date('Y-m-d H:i:s');

        $insertedId =  self::insertGetId($insert);

        return $insertedId;
    }

    public static function updateThumbnail($projectId, $media)
    {
        $projectMedia = ProjectMedia::where('ref_id', $media['id'])->first();
        if (count((array) $projectMedia)) {
            if (self::where('id', $projectId)->update(['thumbnail_media_id' => $projectMedia['id']])) {
                return true;
            }
        }
        return false;
    }

    public static function updateDetails($projectId, $project , $userDetails){

        $update['company_id']       = $userDetails['company_id'];
        $update['name']             = $project['name'];
        $update['address1']         = $project['address1'];
        $update['address2']         = $project['address2'];
        $update['state_id']         = $project['state_id'];
        $update['city_id']          = $project['city_id'];
        $update['postal_code']      = $project['postal_code'];
        $update['claim_num']        = $project['claim_num'];
        $update['sales_tax']        = $project['sales_tax'];
        $update['inspection_date']  = $project['inspection_date'];
        $update['latitude']         = $project['latitude'];
        $update['longitude']        = $project['longitude'];
        $update['customer_email']        = $project['customer_email'];
        $update['status_id']        = $project['status_id'];
        $update['project_status']   = $project['project_status'];
        $update['ref_id']           = $project['id'];
        $update['crm_project_id']   = $project['crm_project_id'];
//        $update['assigned_user_id'] = $userDetails['user_id'];
//        $update['user_id']          = $userDetails['user_id'];
        $update['updated_at']       = date('Y-m-d H:i:s');

        return self::where(['id' => $projectId])->update($update);
    }

    public static function getById($id)
    {
        $query = self::with(['getSingleMedia','complete_address','assigned_user','company'])->select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getList($param)
    {
        $query = self::with(['getSingleMedia' ,'complete_address'])->selectRaw('*');
        $query->where('company_id', $param['company_id']);

        if (!empty($param['type']) && $param['type'] == 1) {
            $query->where('user_id', $param['user_id']);
        } else {
            $query->where('assigned_user_id', $param['user_id']);
            $query->where('user_id', '<>', $param['user_id']);
        }

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('project.name', 'LIKE', "%$keyword%");
                $where->orWhere('project.address1', 'LIKE', "%$keyword%");
            });
        }

        if(!empty($param['project_status'])){
            $query->where('project_status',$param['project_status']);
        } else {
            $query->where('project_status', 1);
        }

        if (!empty($param['paginate'])) {
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        } else {
//            die("END");
            return $query->get();
        }
    }

    public static function getListWithMedia($param)
    {
        $companyId = $param['company_id'];
        $userId = $param['user_id'];

        if (!empty($param['type']) && $param['type'] == 1) {
            $typeWhere = "AND user_id = $userId" ;
        } else {
            $typeWhere = "AND assigned_user_id = $userId" ;
        }


        if (!empty($param['keyword'])) {
            //echo "AAA";die;
            $keyword = $param['keyword'];
            $keywordWhere = "
            AND (name LIKE '%$keyword%' OR 
            address1 LIKE '%$keyword%' )";
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
                $where->orWhere('address1', 'LIKE', "'%$keyword%'");
            });
        }
        $sql = "
        SELECT *, (SELECT path FROM project_media AS pm1 WHERE `pm1`.project_id = `project`.id ORDER BY id ASC LIMIT 1) AS media
        FROM project WHERE 
        company_id = $companyId
        $typeWhere
        ";

        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getCompanyProjectsGrid($params){
        $output = [];
        parse_str($params['custom_search'], $output);

        $query = self::with(['getSingleMedia'])->leftJoin('user AS u', 'u.id', '=','project.assigned_user_id')
            ->where(['project.company_id' => $params['company_id']]);

        $mediaPath = env('BASE_URL').Config::get('constants.USER_IMAGE_PATH');
        $placeHolder = env('BASE_URL').'image/default_user.png';
        $mapImagePath = env('BASE_URL').'uploads/map/map_';
        // uploads/map/map_{$projectId}.jpg
        $query->selectRaw("
        project.id ,
            project.name ,
            project.address1,
            project.created_at , 
            project.project_status , 
            project.last_crm_sync_at,            
            project.inspection_date,            
            project.claim_num,            
            project.customer_email,            
            CONCAT(u.first_name,' ',u.last_name) AS assigned_user,            
            IF(CONCAT('$mediaPath',u.image_url) IS NULL or CONCAT('$mediaPath',u.image_url) = '', '$placeHolder', CONCAT('$mediaPath',u.image_url)) AS image_url,
            CONCAT('$mapImagePath',project.id,'.jpg') project_map_image
            
        ");


        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->whereRaw("
                (project.name LIKE '%$keyword%'            
                OR u.first_name LIKE '%$keyword%'
                OR u.last_name LIKE '%$keyword%')
            ");
        }

//        "filter_created_date" => "2022-01-12"
//  "filter_project_status" => "2"
//  "filter_inspectors" => "81"

        //<editor-fold desc="Filters">
        if (!empty($output['filter_created_date'])) {
            $query->whereDate("project.created_at", $output['filter_created_date']);
        }

        if (!empty($output['filter_project_status'])) {
            $query->whereRaw("
                project.project_status = {$output['filter_project_status']}
            ");
        }

        if (!empty($output['filter_inspectors'])) {
            $query->whereRaw("
                project.assigned_user_id = {$output['filter_inspectors']}
            ");
        }
        //</editor-fold>

        $sortMap = [
            'project.name',
            'assigned_user',
            'project.created_at',
        ];

        $data['total_record'] = $query->count();

//        $params['pageSize']
//        $params['pageNumber']


//        if(empty($sortMap[$params['column_index']])){
//            $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
//            $query = $query->take($params['length'])->skip($params['start'])->orderBy('id','DESC');
//        }else{
//            $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
//            $query = $query->take($params['length'])->skip($params['start'])->orderBy($sortMap[$params['column_index']],$params['sort']);
//        }

        if(empty($params['pageSize']) OR empty($params['pageNumber']) ){
            $params['pageSize'] = 8;
            $params['pageNumber'] = 2;
        }

        $query->take( $params['pageSize'])->skip(($params['pageNumber']-1)*$params['pageSize'])->orderBy('created_at','DESC');

        $query = $query->get();

        $query = $query->map(function ($item,$key){

            $imagePath = "uploads/map/map_{$item['id']}.jpg";
            if(!file_exists(public_path($imagePath))){
                $item['project_map_image'] = NULL;
            }
            return $item;
        });

        $data['records'] = $query->toArray();

        return $data;
    }

    public static function getCompanyProjectsDatatable_withUsers($params){
        $output = [];
        parse_str($params['custom_search'], $output);

//        Helper::p($output,'$output');
//        Helper::pd($params,'$params');

        $query = self::with(['getSingleMedia','assigned_user'])->leftJoin('user AS u', 'u.id', '=','project.assigned_user_id')
            ->where(['project.company_id' => $params['company_id']]);

        $mediaPath = env('BASE_URL').Config::get('constants.USER_IMAGE_PATH');
        $placeHolder = env('BASE_URL').'image/default_user.png';

        $query->selectRaw("
        project.id ,
            project.name ,
            project.address1,
            project.created_at , 
            project.last_crm_sync_at , 
            CONCAT(u.first_name,' ',u.last_name) AS assigned_user,            
            IF(CONCAT('$mediaPath',u.image_url) IS NULL or CONCAT('$mediaPath',u.image_url) = '', '$placeHolder', CONCAT('$mediaPath',u.image_url)) AS image_url
            
        ");
        if (!empty($output['keyword'])) {
            $keyword = $output['keyword'];
            $query->whereRaw("
                (project.name LIKE '%$keyword%'            
                OR u.first_name LIKE '%$keyword%'
                OR u.last_name LIKE '%$keyword%')
            ");
        }

        $sortMap = [
            'project.name',
            'assigned_user',
            'project.created_at',
        ];

        $data['total_record'] = count(((array) $query->get() ));


        if(empty($sortMap[$params['column_index']])){
            $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
            $query = $query->take($params['length'])->skip($params['start'])->orderBy('id','DESC');
        }else{
            $params['column_index'] = empty($sortMap[$params['column_index']]) ? 0 : $params['column_index'];
            $query = $query->take($params['length'])->skip($params['start'])->orderBy($sortMap[$params['column_index']],$params['sort']);
        }


        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function storeCompanyGroupCategory($request)
    {
        return \DB::table('company_group_category')->insertGetId([
        ]);
    }

    public static function getCompleteProject($categories,$projectId){

        foreach ($categories['required_category'] AS $key => $item){
            /*MainCat Media + Tags*/
            $projectWithMedia = self::getProjectMediaAndTag_byProjectIdAndCategoryId($projectId,$item);
            $categories['required_category'][$key]['media'] = $projectWithMedia['project_media'];
        }

        foreach ($categories['damaged_category'] AS $key => $item){
            /*Survey*/

            // Prior to Apr-2021
            // dd($item,'$item');
            // $projectSurvey = self::getProjectSurveyAndResponse_byProjectId($projectId,$categories['damaged_category'][$key]['id']);
            // $categories['damaged_category'][$key]['survey'] = $projectSurvey['project_survey'];

            if(!empty($item['category_survey'])){
            //<editor-fold desc="Updated Apr-2021 ">
                /** Benefit: one less query in per iteration "getProjectSurveyAndResponse_byProjectId()" */

                /**Getting Survey response */
                $pq = ProjectQuery::where(['project_id' => $projectId])->whereIn('query_id',array_pluck($item['category_survey'],'id'))->get(['id','project_id','query_id','response'])->keyBy('query_id');

//                p($item['category_survey'],'category_survey');
//                p($pq->toArray(),'$pq');

                if(!empty($pq)){
                    /** Binding response to category_survey*/
                    foreach($item['category_survey'] AS $surveyKey => $surveyItem){

                        /** Adding only question which have response in ProjectQuery */
                        if(!empty($pq[$surveyItem['id']]['response'])){
                            $categories['damaged_category'][$key]['survey'][$surveyKey] = $categories['damaged_category'][$key]['category_survey'][$surveyKey];
                            $categories['damaged_category'][$key]['survey'][$surveyKey]['response'] = $pq[$surveyItem['id']]['response'];
                        }else{
//                            dump('response not',$categories['damaged_category'][$key]['survey']);
                        }
                    }


                    if(!empty($categories['damaged_category'][$key]['survey'])){
                        /** ProjectQuery::parseSurvey is used for handling option radio/checkbox
                         * + putting from 'category_survey' to 'survey' for API sake
                         */

//                        p($categories['damaged_category'][$key]['survey'][0],'survey');
                        $categories['damaged_category'][$key]['survey'] = ProjectQuery::parseSurvey($categories['damaged_category'][$key]['survey']);
//                        pd($categories['damaged_category'][$key]['survey'][0],'survey');

                    }
                }
                //</editor-fold>
            }

            /*Below for subcat (Photoview)*/
            if(!empty($categories['damaged_category'][$key]['get_child'])){
                foreach($categories['damaged_category'][$key]['get_child'] AS $subKey => $subItem){
                    /*SubCat Media + Tags*/
                    $projectWithMedia = self::getProjectMediaAndTag_byProjectIdAndCategoryId($projectId,$subItem);
                    $categories['damaged_category'][$key]['get_child'][$subKey]['media'] = $projectWithMedia['project_media'];

                }/*END FOREACH */
            } /*END IF */
        }/*END FOREACH */

        /*Additional Cat (is always 1) Media + Tags*/
        $projectWithMedia = self::getProjectMediaAndTag_byProjectIdAndCategoryId($projectId, ['id' => $categories['additional_photos']['id'] ] );

        if(count(((array) $projectWithMedia['project_media'])) > 0){
            $categories['additional_photos']['media'] = $projectWithMedia['project_media'];
        }
        $project = self::getById($projectId);
        $project['project_media'] = $project->getSingleMedia;
        $project['categories'] = $categories;
        return $project;
    }

    public static function getProjectMediaAndTag_byProjectIdAndCategoryId($projectId, $category)
    {

        /** Done:(on Mar-2021) We can optimize this method
         *      - Problem: We're getting tag & UOM details from leftjoin inside media_tags_extended, that search in all tags of the company
         *      - Solution: $category already has tag details Loop and copy that since we're already looping when creating pdf report.
         */


        $PMedia =  self::with(['project_media' => function($q) use($category) {
            $q->where('category_id', $category['id'])->with(['media_tags_extended'
            => function($q){

               /**  LeftJoin "->leftJoin('tag AS t" is removed because we're using $category['category_tags'] to map the tag details via tag_id few lines below
                *   Reason: 1 less join per media
                */
//->leftJoin('tag AS t','t.id','=' ,'project_media_tag.tag_id' )
////                    ->leftJoin('uoms AS u','u.id','=' ,'t.uom_id' )
//                            t.id,
//                            t.company_id,
//                            t.name,
//                            t.has_qty,
//                            t.price,
//                            t.material_cost, t.labor_cost,t.equipment_cost,t.supervision_cost,t.margin,
//                            t.uom_id AS uom,
//                            project_media_tag.target_id,
//                            project_media_tag.target_type,
//                            project_media_tag.created_at
//                            u.title AS uom,
                    $q->selectRaw('
                        project_media_tag.tag_id ,
                        project_media_tag.qty AS selected_qty,
                        project_media_tag.target_id,                        
                        project_media_tag.target_type                            
                    ');

//                $q->whereNull('t.deleted_at');

                }
            ])->selectRaw('ref_id AS id, id AS ref_id, project_id, category_id, path, note, 1 AS `status`');
        }])->where('id',$projectId)->first()->toArray();

        $catTagsCollection = collect($category['category_tags'])->keyBy('id')->map(function ($item,$key){
            $only  = ['company_id', 'has_qty', 'hover_field_id', 'hover_field_type_id', 'id', 'is_required', 'name', 'ref_id', 'is_selected', 'quantity'];
            return  array_only($item,$only);
        });

        foreach ($PMedia['project_media'] as $mediaKey => $mediaItem) {

            $mediaTags = collect($PMedia['project_media'][$mediaKey]['media_tags_extended'])->keyBy('tag_id')->map(function ($mediaTag) use($catTagsCollection) {
                 $mediaTag['id'] = $mediaTag['tag_id'];
                return collect($mediaTag)->merge($catTagsCollection->get($mediaTag['tag_id']));
            });

            $PMedia['project_media'][$mediaKey]['media_tags_extended'] = array_values($mediaTags->toArray());
        }
        return $PMedia;
    }

    public static function getProjectSurveyAndResponse_byProjectId($projectId,$categoryId = NULL ){
        $projectSurvey =  self::with(['project_survey' => function($q) use($categoryId) {
            $q->join('query AS q','q.id' , '=', 'project_query.query_id')->selectRaw('                 
                    project_query.id AS project_query_id,
                    project_query.project_id,
                    project_query.query,                        
                    project_query.response,                    
                    project_query.created_at,                     
                    q.id,  
                    q.company_id,       
                    q.type,    
                    q.image_url,    
                    q.category_id,  
                    q.options,
                    q.photo_view_id
                 ');
            if(!empty($categoryId))
                $q->where('category_id',$categoryId);

        }])->where('id',$projectId)->first()->toArray();

        $projectSurvey['project_survey'] = ProjectQuery::parseSurvey($projectSurvey['project_survey']);
        return $projectSurvey;
    }

    public static function getByRefId($id)
    {
//        with(['getSingleMedia','complete_address','assigned_user'])
        $query = self::select();
        return $query->where('ref_id', $id)
            ->first();
    }

    public function getCrmProject($projectId){

        $project = self::getById($projectId);
        $pMediaTag = ProjectMediaTag::getByProjectId($projectId);
        $crmSpecs = CrmModel::parseProjectSpecs($pMediaTag);
        $project['specs'] = $crmSpecs;

        $crmProject = [
            'access_token' => NULL,
            'project_id' => $project['crm_project_id'],
            'employee_id' => $project['company']['crm_employee_id'],
            'build_specs' => $crmSpecs,
        ];

        return $crmProject;
    }

    /*Gets in the format of CRM*/
    public function getCrmProjects($projectParam){

        $projectObj = self::selectRaw('id,company_id,last_crm_sync_at,crm_project_id,company_id,name')->with(['project_media.tags_data' , 'assigned_user','company']);
        $projectObj->whereNotNull('crm_project_id');
        if(is_array($projectParam)){
            $projectObj->whereIn('id',array_column($projectParam,'id'));
        }else{
            $projectObj->where('id',$projectParam);
        }

        $projectArr = $projectObj->get()->toArray();
//        Helper::pd($projectArr,'$projectObj');
        return $projectArr;
    }

    public function getCRM_notSyncedProject($take = 10, $id = 0)
    {
        $q = $this->whereNull('last_crm_sync_at')->whereNotNull('crm_project_id')->whereRaw("crm_project_id <> ''")->selectRaw("id")->take($take);
        if (!empty($id)) {
            $q->where('id', $id);
        }
        return $q->get();
    }

    public function syncedProjects(array $projectIds)
    {
        $q = new self();
        return $q->whereIn('id' ,$projectIds)->update(['last_crm_sync_at' => date('Y-m-d H:i:s')]);
    }

    /*Relation Start*/

    public function getSingleMedia(){
        $mediaPath = env('BASE_URL').Config::get('constants.MEDIA_IMAGE_PATH');
        $placeHolder = env('BASE_URL').'image/placeholder.png';

//        IF(CONCAT('$mediaPath',path) IS NULL or CONCAT('$mediaPath',path) = '', '$placeHolder', CONCAT('$mediaPath',path))
        return $this->hasOne('App\Models\ProjectMedia','project_id','id')
            ->join('category AS c','c.id','=','project_media.category_id')
            ->whereRaw('thumbnail = 1')
            ->selectRaw("project_media.id, project_id, category_id, path, note, 
            IF(CONCAT('$mediaPath',path) IS NULL or CONCAT('$mediaPath',path) = '', '$placeHolder', CONCAT('$mediaPath',path)) image_url")->oldest('project_media.created_at');

    }

    public function project_media(){
        $mediaPath = env('BASE_URL').Config::get('constants.MEDIA_IMAGE_PATH');

        return $this->hasMany('App\Models\ProjectMedia','project_id','id')
            ->selectRaw("
                                id,
                                project_id,
                                created_at,
                                category_id,
                                path,
                                note,
                                ref_id,
                                CONCAT('$mediaPath',path) AS image_url
                                ");
    }

    public function project_survey(){
        return $this->hasMany('App\Models\ProjectQuery','project_id','id');
    }

    public function assigned_user(){
        return $this->belongsTo('App\Models\User','assigned_user_id','id');
    }

    public function complete_address(){
        return $this->belongsTo('App\Models\City','city_id','id')
            ->join('states' , 'states.id','=','cities.state_id')
            ->join('countries' , 'countries.id','=','states.country_id')
            ->selectRaw("cities.id, cities.name, states.name AS state_name, countries.name AS country_name,
            CONCAT(cities.name,', ', states.name ) AS complete_address");
    }

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
}

