<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Models\Admin;
use App\Models\Category;
use App\Models\CompanyGroupCategory;
use App\Models\HoverJob;
use App\Models\NotificationIdentifier;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\ProjectMediaTag;
use App\Models\ProjectQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{

    function __construct()
    {
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes
        ini_set('max_execution_time', 0); // for infinite time of execution
        parent::__construct();
        $this->middleware(LoginAuth::class, [
            'only' => [
                'store', 'detail', 'storeGroup', 'index', 'show', 'edit', 'update', 'getSetting', 'statusUpdate',
                'profile', 'updateLocation', 'userSubscription', 'subscription', 'images', 'projectList', 'detailView',
                'storeImages', 'storeComplete', 'complete', 'listAll', 'updateComplete', 'imageSync' , 'reportView' ,'report'
//           , 'createReport'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $crm = new Crm();
//        $crm->authenticate();
//        die('end');

        $request['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
//        print_r($request->all()); die;
        $param = $request->all();
        $param['paginate'] = FALSE;
        $list = Project::getList($param);
       // dd($list);
//        pd($list->toArray(),'$list');

        $this->__is_paginate = FALSE;
        return $this->__sendResponse('Project', $list, 200, 'Project list retrieved successfully.');
    }

    public function listAll(Request $request)
    {
        $request['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
        $param = $request->all();
        $param['paginate'] = FALSE;
        $list = Project::getList($param);
        $this->__is_paginate = false;
        $this->__is_collection = true;
        return $this->__sendResponse('Project', $list, 200, 'Project list retrieved successfully.');
    }

    public function complete(Request $request)
    {
        //<editor-fold desc="Validation">
        $param_rules['project_id'] = [
            'required',
            'int',
            Rule::exists('project', 'id')->whereNull('deleted_at')->where('company_id',$request['company_id'])
        ];
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == TRUE)
            return $response;
        //</editor-fold>

        $categories = User::getUserCategories($request->all());
//        pd($categories['damaged_category'],'damaged_category');
        $completeProject = Project::getCompleteProject($categories, $request['project_id']);
//        dd($completeProject->toArray(),'$completeProject');

        $country = Admin::getCountries(['id' => $completeProject->country_id])->toArray();
        $state = Admin::getStates(['id' => $completeProject->state_id])->toArray();
        $city = Admin::getCities(['id' => $completeProject->city_id])->toArray();

        $completeProject['country_name'] = $country[0]->name;
        $completeProject['state_name'] = $state[0]->name;
        $completeProject['city_name'] = $city[0]->name;

        $hj = HoverJob::getBy(['project_ref_id' => $completeProject->ref_id]);
        $completeProject['job_id'] = $hj[0]->job_id;

        if ($completeProject->is_updated) {
            Project::where(['id' => $request['project_id']])->update(['is_updated' => 0]);

            $completeProject->is_updated = 0;
        }

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $completeProject, 200, 'Complete Project retrieved successfully.');
    }

    public function detail(Request $request, $id)
    {
        $request['project_id'] = $id;
        $param_rules['project_id'] =
            [
                'required',
                'int',
                Rule::exists('project', 'id')->whereNull('deleted_at')
            ];

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == TRUE)
            return $response;

        $categories = User::getUserCategories($request->all());
        $project = Project::getCompleteProject($categories, $id);

        $country = Admin::getCountries(['id' => $project->country_id])->toArray();
        $state = Admin::getStates(['id' => $project->state_id])->toArray();
        $city = Admin::getCities(['id' => $project->city_id])->toArray();

        $project['country_name'] = $country[0]->name;
        $project['state_name'] = $state[0]->name;
        $project['city_name'] = $city[0]->name;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $project, 200, 'Project details retrieved successfully.');
    }

    public function statusUpdate(Request $request, $id)
    {
        $request['project_id'] = $id;
        $param_rules['project_id'] = [
            'required',
            'int',
            Rule::exists('project', 'id')->whereNull('deleted_at')
        ];

        $param_rules['project_status'] = 'required|int';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == TRUE)
            return $response;

        //<editor-fold desc="Remove for changing API for simple status update">
        //        $users = User::where(['company_id' => $request->company_id])->first()->toArray();
//        $params = [
//            'company_id' => $users['company_id'],
//            'company_group_id' => $users['company_group_id'],
//        ];

//        print_r($params); //die;
//        $categories = CompanyGroupCategory::getChildMinQuantity($params, TRUE);
//        print_r($categories);
//        die;

//        $media = ProjectMedia::checkProjectRequiredMedia($categories, $id);
//        $media = json_decode(json_encode($media), true);
//
//        foreach ($media AS $item) {
//            if ($item['match_result'] <= 0) {
//                return $this->__sendError('Validation Error', $item['name'] . ' has less than required quantity.');
//            }
//        }
        //</editor-fold>

        $up = Project::where('id', $id)->update(['project_status' => $request->project_status]);

        $project = Project::getById($id);

        //<editor-fold desc="Remove for changing API for simple status update 2">
        //        $mediaData = $this->getMediaAndTagById($id);
//        $project['media'] = $mediaData['media'];
//        $project['media_tag'] = $mediaData['media_tag'];
        //</editor-fold>


        $country = Admin::getCountries(['id' => $project->country_id])->toArray();
        $state = Admin::getStates(['id' => $project->state_id])->toArray();
        $city = Admin::getCities(['id' => $project->city_id])->toArray();
        $project['country_name'] = $country[0]->name;
        $project['state_name'] = $state[0]->name;
        $project['city_name'] = $city[0]->name;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $project, 200, 'Project status updated successfully.');

    }

    public function getMediaAndTagById($id)
    {
        $data = [];
        $data['media'] = ProjectMedia::getByProjectId($id)->get();

        $mediaIdsArray = array_column($data['media']->toArray(), 'id');
        $data['media_tag'] = ProjectMediaTag::select("target_id", "target_type", "tag_id", "name", "qty", "created_at")->whereIn('target_id', $mediaIdsArray)->where('target_type', 'media')->get();
        return $data;
    }

    public function images(Request $request, $id)
    {
        //<editor-fold desc="Validation">
        $request['project_id'] = $id;
        $param_rules['project_id'] =
            [
                'required',
                'int',
                Rule::exists('project', 'id')->whereNull('deleted_at')
            ];

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == TRUE)
            return $response;
        //</editor-fold>

        $project = Project::getBy(['id' => $id],['project_media']);

        $this->__is_paginate = false;
//        $this->__collection = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $project[0], 200, 'Project Images retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request['assigned_user_id'] = !empty($request['assigned_user_id']) ? $request['assigned_user_id'] : $request['user_id'];
        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['address1'] = 'required|string|max:100';
        $param_rules['address2'] = 'string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
        $param_rules['user_id'] = 'required|int';
        $param_rules['customer_email'] = 'required|email|max:100';
        $param_rules['claim_num'] = 'nullable|string|max:100';
        $param_rules['inspection_date'] = 'required|date_format:Y-m-d';
        $param_rules['latitude'] = 'required|string|max:100';
        $param_rules['longitude'] = 'required|string|max:100';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;


        $project = new Project();
        $project->company_id = $request->company_id;
        $project->name = $request->name;
        $project->address1 = $request->address1;
        $project->address2 = $request->address2;
        $project->assigned_user_id = $request->assigned_user_id;
        $project->user_id = $request->user_id;
        $project->customer_email = $request->customer_email;

        $project->claim_num = $request->claim_num;
//        $project->inspection_date = date('Y-m-d ', strtotime($request->inspection_date));
        $project->inspection_date = $request->inspection_date;
        $project->latitude = $request->latitude;
        $project->longitude = $request->longitude;

        if (!$project->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }


        $users = User::where(['company_id' => $request->company_id, 'id' => $request['user_id']])->first()->toArray();
        $params = [
            'company_id' => $users['company_id'],
            'company_group_id' => $users['company_group_id'],
        ];

        $categories = CompanyGroupCategory::getCategories($params, TRUE);

        $list = Project::getById($project->id);
        $list['categories'] = $categories;

        $country = Admin::getCountries(['id' => $project->country_id])->toArray();
        $state = Admin::getStates(['id' => $project->state_id])->toArray();
        $city = Admin::getCities(['id' => $project->city_id])->toArray();

        $list['country_name'] = $country[0]->name;
        $list['state_name'] = $state[0]->name;
        $list['city_name'] = $city[0]->name;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $list, 200, 'Project added successfully.');
    }

    public function childParsing($categories)
    {
        $categoryArr = [];
        foreach ($categories AS $key => $item) {
            if ($item['category2_parent_id'] == 0) {
                $categoryArr[$item['category1_id']]['category_id'] = $item['category2_id'];
                $categoryArr[$item['category1_id']]['category_name'] = $item['category2_name'];
                $categoryArr[$item['category1_id']]['category_min_quantity'] = $item['category2_min_quantity'];
            } else {
                $categoryArr[$item['category1_id']]['category_id'] = $item['category1_id'];
                $categoryArr[$item['category1_id']]['category_name'] = $item['category1_name'];
                $categoryArr[$item['category1_id']]['category_min_quantity'] = $item['category1_min_quantity'];
                $categoryArr[$item['category1_id']]['children'][$item['category2_id']]['category_id'] = $item['category2_id'];
                $categoryArr[$item['category1_id']]['children'][$item['category2_id']]['category_name'] = $item['category2_name'];
                $categoryArr[$item['category1_id']]['children'][$item['category2_id']]['category_min_quantity'] = $item['category2_min_quantity'];
            }
        }/*End of foreach*/

        $response = [];
        foreach ($categoryArr as $item) {
            $tmp = $item;
            unset($tmp['children']);
            foreach ($item['children'] as $sub_child)
                $tmp['children'][] = $sub_child;
            $response[] = $tmp;
        }
        return $response;
    }

    public function storeImages(Request $request, $projectId, $categoryId)
    {
        $request['tags'] = json_decode($request['tags'], true);
        $request['project_id'] = $projectId;
        $request['category_id'] = $categoryId;
        $param_rules['project_id'] = [
            'required',
            'int',
            Rule::exists('project', 'id')->whereNull('deleted_at'),
        ];


        $param_rules['category_id'] = 'required|int';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $tags = $request['tags'];
        $note = $request['note'];

        $imageName = "$projectId-$categoryId-" . time() . '_' . rand();
//        echo $imageName; die;
        if ($request->hasFile('image_url')) {
            $request['system_image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                $imageName,
                Config::get('constants.MEDIA_IMAGE_PATH')
            );
//            print_r($request['system_image_url']);die;
        } else {
            return $this->__sendError('Validation Error', 'Can\'t find image', $code = 404);
        }

        ProjectMedia::createBulk($projectId, $categoryId, $note, 'image', [$request['system_image_url']]);
        $projectMedia = ProjectMedia::orderBy('id', 'desc')->first();


        ProjectMediaTag::createRecords($projectMedia['id'], $tags);

        $project = Project::find($projectId);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $project, 200, 'Project Image added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $param_rules['id'] = 'required|exists:user';
        $response = $this->__validateRequestParams(['id' => $request['user_id']], $param_rules);

        if ($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $param_rules['target_id'] = 'required|exists:user,id';

        if (!isset($request['target_id']))
            $request['target_id'] = $request['user_id'];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams(['target_id' => $request['target_id']], $param_rules);

        if ($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('User', User::getById($request['target_id']), 200, 'User retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getSetting(Request $request)
    {
        $this->__is_paginate = false;
        return $this->__sendResponse('Settings', User::getUserSetting($request['user_id']), 200, 'User retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $request['id'] = $id;

        $param_rules['company_id']       = 'required|int';
        $param_rules['name']             = 'required|string|max:100';
        $param_rules['address1']         = 'required|string|max:100';
        $param_rules['address2']         = 'string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
        $param_rules['customer_email']   = 'nullable|email|max:100';
        $param_rules['claim_num']        = 'nullable|string|max:100';
        $param_rules['inspection_date']  = 'required|date';
        $param_rules['latitude']         = 'required|string|max:100';
        $param_rules['longitude']        = 'required|string|max:100';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $project = Project::find($id);

        $project->name = $request->name;
        $project->address1 = $request->address1;
        $project->address2 = $request->address2;
        $project->assigned_user_id = $request->assigned_user_id;
        $project->customer_email = $request->customer_email;
        $project->claim_num = $request->claim_num;
        $project->inspection_date = $request->inspection_date;
        $project->latitude = $request->latitude;
        $project->longitude = $request->longitude;

        if (!$project->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

        $list = Project::getById($project->id);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $list, 200, 'Project updated successfully.');

    }

    public function delete(Request $request, $id)
    {
        $request['id'] = $id;
        $param_rules['id'] = 'required|int|';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true)
            return $response;

        $childs = Category::where('parent_id', $id)->get()->toArray();


        if (count(((array) $childs)) > 0) {

            Category::destroy(array_column($childs, 'id'));
        }

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', [], 200, 'Category deleted successfully.');
    }

    public function projectList(Request $request)
    {
        $this->__view = 'subadmin/project_mgmt';

        $param['company_id'] = $request['company_id'];
        $param['keyword'] = $request['keyword'];
        $param['paginate'] = TRUE;

        $userWhere = [
            'company_id' => $request['company_id'],
            'user_group_id' => 2,
        ];

        $list['states'] = Admin::getStates(['country_id' => 254]);
        $list['inspectors'] = User::where($userWhere)->selectRaw("id, CONCAT(first_name,' ',last_name) AS userNames")->get();
        $list['latest_photos'] = ProjectMedia::getLatestPhotos($request->all());
        //dd($list);
        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function projectGrid(Request $request)
    {
        $params = $request->all();

        $output = [];
        parse_str($params['custom_search'], $output);
//        dd($output);
        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];

        $params['parent_id'] = 0;
        $params['paginate']  = TRUE;
        $params['company_id'] = $request['company_id'];
        $params['user_group_id'] = 2;
        $params['type'] = 1;
        $params['keyword'] = $request['keyword'];

        $dataTableRecord = Project::getCompanyProjectsGrid($params);
        // dd($dataTableRecord);
//        p($dataTableRecord['records'],'$dataTableRecord');
//        dd('$records',$dataTableRecord);

        return response()->json($dataTableRecord);

        /** set data grid output */
//        To be removed commented on Jan-2023
       $records["data"] = [];
       if(count(((array) $dataTableRecord['records'])))
       {
           foreach($dataTableRecord['records'] as $record){
               $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"
               data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
               $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger"
               data-module="require_photo" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

               $reportPath = public_path(config('constants.PDF_PATH') .'project_report_'. $record->id . '.pdf');
               $reportUrl = "";
               if(file_exists($reportPath)){
                   $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'project_report_'.$record->id.'.pdf');
               }

               $placeHolder = env('BASE_URL').'image/placeholder.png';

               if(!empty($record->getSingleMedia->image_url)){
                   $titleImage = '<img src="'.$record->getSingleMedia->image_url.'" class="img-responsive wd-100 myImg" />';
               }else{
                   $titleImage = '<img src="'.$placeHolder.'" class="img-responsive wd-100" />';
               }

               $mediaCount = ProjectMedia::where(['project_id'=> $record->id])->count();


               $records["data"][] = [
                   'id' => $record->id,
                   'image' =>  $titleImage,
                   'name' => $record->name.'<br>'.$record->address1.'<br>'.$record->address2,
                   'name' => $record->inspect,
                   'media_count' => $mediaCount,
                   'assigned_user' => $record->assigned_user.'<br> <img src="'.$record->image_url.'" class="img-responsive" style="width:30px;"/>',
                   /*'last_crm_sync_at' => $record->last_crm_sync_at,*/
                   'report_url' => $reportUrl,
                   'created_at' => date('Y-m-d h:i:s A',strtotime($record->created_at)),
                   'inspection_date' => date('Y-m-d h:i:s A',strtotime($record->inspection_date)),
               ];
           }
       }

       $records["draw"] = (int)$request->input('draw');
       $records["recordsTotal"] = $dataTableRecord['total_record'];
       $records["recordsFiltered"] = $dataTableRecord['total_record'];
       //dd($records);
       return response()->json($records);
    }

    public function projectDatatable(Request $request)
    {
        $params = $request->all();

        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];

        $params['parent_id'] = 0;
        $params['paginate']  = TRUE;
        $params['company_id'] = $request['company_id'];
        $params['user_group_id'] = 2;
        $params['type'] = 1;
        $params['keyword'] = $request['keyword'];

        $dataTableRecord = Project::getCompanyProjectsDatatable_withUsers($params);
//        p($dataTableRecord['records'],'$dataTableRecord');

        /** set data grid output */
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'])))
        {
            foreach($dataTableRecord['records'] as $record){
                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"
                data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger"
                data-module="require_photo" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $reportPath = public_path(config('constants.PDF_PATH') .'project_report_'. $record->id . '.pdf');
                $reportUrl = "";
                if(file_exists($reportPath)){
                    $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'project_report_'.$record->id.'.pdf');
                }

                $placeHolder = env('BASE_URL').'image/placeholder.png';

                if(!empty($record->getSingleMedia->image_url)){
                    $titleImage = '<img src="'.$record->getSingleMedia->image_url.'" class="img-responsive wd-100 myImg" />';
                }else{
                    $titleImage = '<img src="'.$placeHolder.'" class="img-responsive wd-100" />';
                }

                $mediaCount = ProjectMedia::where(['project_id'=> $record->id])->count();


                $records["data"][] = [
                    'id' => $record->id,
                    'image' =>  $titleImage,
                    'name' => $record->name.'<br>'.$record->address1.'<br>'.$record->address2,
                    'media_count' => $mediaCount,
                    'assigned_user' => $record->assigned_user.'<br> <img src="'.$record->image_url.'" class="img-responsive" style="width:30px;"/>',
                    /*'last_crm_sync_at' => $record->last_crm_sync_at,*/
                    'report_url' => $reportUrl,
                    'created_at' => date('Y-m-d h:i:s A',strtotime($record->created_at)),
                ];
            }
        }


        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function storeProject(Request $request)
    {
        /*
         * Webpage
         * */

        $this->__view = 'subadmin/project?page=' . $request['page'];
        $this->__is_redirect = true;
        //<editor-fold desc="Validation Block">
        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['address1'] = 'required|string|max:100';
        $param_rules['address2'] = 'string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
        $param_rules['user_id'] = 'required|int';
        $param_rules['customer_email'] = 'nullable|email|max:100';
        $param_rules['claim_num'] = 'nullable|string|max:100';
        $param_rules['sales_tax'] = 'nullable|numeric|min:1';
        $param_rules['lat'] = 'required|numeric';
        $param_rules['long'] = 'required|numeric';
        // $param_rules['inspection_date'] = 'nullable|date_format:Y-m-d|after:tomorrow';
//        $param_rules['latitude'] = 'required|string|max:100';
//        $param_rules['longitude'] = 'required|string|max:100';

        $messages = [
            'lat.required' => 'The address needs to be from Google',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules,$messages);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Added Successfully', $error['data']);
            return $response;
        }
        //</editor-fold>
        $project = new Project();
        $project->company_id        = $request->company_id;
        $project->name              = $request->name;
        $project->address1          = $request->address1;
        $project->address2          = $request->address2;
        $project->assigned_user_id  = $request->assigned_user_id;
        $project->user_id           = $request->user_id;
        $project->customer_email    = $request->customer_email;
        $project->claim_num         = $request->claim_num;
        $project->status_id         = 1;
        $project->project_status    = 1;
        $project->sales_tax         = $request->sales_tax;
        $project->inspection_date   = $request->inspection_date;
        $project->latitude          = $request->lat ?: '';
        $project->longitude         = $request->long ?: '';

        if (!$project->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

         $this->saveMap($project->id,$project->latitude,$project->longitude);

        $user = User::where('id', $request->user_id)->first();
        $targetUser = User::where('id', $request->assigned_user_id)->first();

        if ($request['user_id'] != $targetUser->id) {
            $notification_data = [
                'appName' => env('APP_NAME'),
                'user' => $user, /*Actor*/
                'targetUser' => $targetUser,
                'project' => $project,
                'referenceId' => $project->id,
                'referenceModule' => 'project'
            ];
            $custom_data = [];

            NotificationIdentifier::notificationIdentifier('project_assigned', $notification_data, $custom_data);
        } else {
            echo "ELSE";
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', [], 200, 'Project added successfully.');
    }

    public function editProjectDetails(Request $request, $id)
    {
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Project::where($param)->first();

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $list, 200, 'Project detail retrieved successfully.');
    }

    public function updateProject(Request $request, $id)
    {
        $this->__view = 'subadmin/project/edit-project/'.$id;
        $this->__is_redirect = true;

//        dd($request->all());

//        $param_rules['name']    = 'required|string|max:100';
//        $param_rules['address1'] = 'required|string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
//        $param_rules['user_id'] = 'required|int';
//        $param_rules['claim_num'] = 'nullable|string|max:100';
//        $param_rules['inspection_date'] = 'required|date_format:Y-m-d';
//        $param_rules['sales_tax'] = 'nullable|numeric|min:1';
//        $param_rules['lat'] = 'required|string|max:100';
//        $param_rules['long'] = 'nullable|numeric';

        //<editor-fold desc="Validation Block">
        $param_rules['company_id'] = 'required|int';
        $param_rules['name']    = 'required|string|max:100';
        $param_rules['address1'] = 'required|string|max:100';
        $param_rules['address2'] = 'string|max:100';
        $param_rules['assigned_user_id'] = 'required|int';
        $param_rules['user_id'] = 'required|int';
        $param_rules['claim_num'] = 'nullable|string|max:100';
        $param_rules['inspection_date'] = 'required|date';
        $param_rules['sales_tax'] = 'nullable|numeric|min:1';
        $param_rules['lat'] = 'required|string|max:100';
        $param_rules['long'] = 'nullable|numeric';

        $messages = [
            'lat.required' => 'The address1 needs to be from Google',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules,$messages);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Updated Successfully', $error['data']);
            return $response;
        }
        //</editor-fold>


        $project = new Project();
        $project = $project::find($id);
        $project->company_id = $request->company_id;
        $project->name = $request->name;
        $project->address1 = $request->address1;
        $project->address2 = $request->address2;
        $project->assigned_user_id = $request->assigned_user_id;
        $project->claim_num = $request->claim_num;
//        $project->inspection_date = date('Y-m-d ', strtotime($request->inspection_date));
        $project->inspection_date = Carbon::parse($request->inspection_date);
        $project->sales_tax = $request->sales_tax;
        $project->latitude =    $request->lat?: '';
        $project->longitude =   $request->long?: '';


        if (!$project->save()) {
            return $this->__sendError('Query Error', 'Unable to update record.');
        }

        $this->saveMap($project->id,$project->latitude,$project->longitude);

        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', [], 200, 'Project Updated successfully.');
    }

    public function deleteProject(Request $request, $id)
    {
        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;

        $request['id'] = $id;
        $param_rules['id'] = 'required|int|';
        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            return $response;
        }

        $d = Project::where('id', $id)->delete();

        if (!$d) {
            return $this->__sendError('Query Error', 'Unable to Delete record.');
        }
        return $this->__sendResponse('Category', [], 200, 'Project deleted successfully.');
    }

    public function detailView(Request $request, $id)
    {
        $this->__view = 'subadmin/edit_project';

        $list['project'] = Project::getById($id);
        $stateId = $list['project']['state_id'];
        $cityId = $list['project']['city_id'];

        $state = Admin::getStates(['id' => $stateId]);
        $city = Admin::getCities(['id' => $cityId]);
        $list['location']['state'] = (array)$state[0];
        $list['location']['city'] = (array)$city[0];

        $user = User::getById($list['project']['assigned_user_id']);
        $catWhere = [
            'company_id' => $request['company_id'],
            'company_group_id' => $user['company_group_id'],
        ];

        $cats = CompanyGroupCategory::getCategories($catWhere, TRUE);

        $reportPath = public_path(config('constants.PDF_PATH') .'project_report_'. $id . '.pdf');
        $reportUrl = "";
        if(file_exists($reportPath)){
            $list['reportUrl'] = (env('BASE_URL').config('constants.PDF_PATH').'project_report_'.$id.'.pdf');
        }

        $list['proMedia']['required_category'] = ProjectMedia::getMediaForCategories($cats['required_category'], $id);
        $list['proMedia']['damaged_category'] = ProjectMedia::getMediaForCategories($cats['damaged_category'], $id);
        $list['proMedia']['additional_photos'] = ProjectMedia::getMediaForCategories([$cats['additional_photos']], $id);

        $userWhere = [
            'company_id' => $request['company_id'],
            'user_group_id' => 2,
        ];
         $list['inspectors'] = User::where($userWhere)->selectRaw("id, CONCAT(first_name,' ',last_name) AS userNames")->get();

//        pd($list['proMedia']['additional_photos'][0]['media_count'],'$list[\'proMedia\'][\'additional_photos\']');

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Project', $list, 200, 'Project deleted successfully.');
    }

    public function saveSignature(Request $request)
    {
//        echo '<pre>'; print_r($request->all()); exit;

        if ($request->isMethod('post')) {
//            dd('tru',$request['signature_url'],preg_match('/^data:image\/(\w+)\+(\w+;base64,/', $request['signature_url']));

            if (preg_match('/^data:image\/(\w+)\+(\w+);base64,/', $request['signature_url'])) {

                $value = substr($request['signature_url'], strpos($request['signature_url'], ',') + 1);
//                $value = base64_decode($request['signature_url']);
                $value = base64_decode($value);
//                $value = ("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");

                $imagePath = public_path(config('constants.SIGN_PATH'));
                if(!is_dir($imagePath)){
                    mkdir($imagePath);
                }

                $imageName = 'customer_sign'.time()  . '.svg';

                file_put_contents("{$imagePath}/{$imageName}",$value);

            }
        }
    }

    public function storeComplete(Request $request)
    {
        $param_rules['project'] = 'required|string';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        $project = json_decode($request['project'], TRUE);
        /** Note: 'ref_id' is received in 'id' */

        if(empty($project)){
            return $this->__sendError('Error','Invalid JSON format',400);
        }

        //<editor-fold desc="Is project crm id already bound to one of our project">
        if(!empty($project['crm_project_id'])){
            $projectM = new Project();
            $crmBindProjectCount =  $projectM->select('id','crm_project_id')->where('crm_project_id',$project['crm_project_id'])->count();

            if($crmBindProjectCount > 0){
                return $this->__sendError('Error','CRM Project is already bind to a project.',400);
            }
        }
        //</editor-fold>

        $userDetails = [
            'company_id' => $request['company_id'],
            'user_id' => $request['user_id']
        ];

        $projectId = Project::storeDetails($project, $userDetails);
        Project::updateThumbnail($projectId, $project['project_media']);
        $project['id'] = $projectId;

        foreach ($project['categories']['required_category'] AS $key => $item) {

            if (!empty($item['media'])) {
                $res = ProjectMedia::updateCategoryId_AndMediaTags($item['media'], $projectId);

                if (!empty($res['error'])) {
                    return $this->__sendError($res['error'], $res['error_data'], 400);
                }
            }
        }

        foreach ($project['categories']['damaged_category'] AS $key => $item) {

            if (!empty($item['category_survey'])) {

                if (isset($project['categories']['damaged_category'][$key]['signature']) && !empty($project['categories']['damaged_category'][$key]['signature'])) {
                    $image = $project['categories']['damaged_category'][$key]['signature'];  // your base64 encoded
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = $project['categories']['damaged_category'][$key]['id'] . "-" . time() . '_' . rand() . '.' . 'png';

                    \File::put(Config::get('constants.MEDIA_IMAGE_PATH') . '/' . $imageName, base64_decode($image));
                }

                $project['categories']['damaged_category'][$key]['category_survey'] =
                    ProjectQuery::insertSurvey(
                        $item['category_survey'],
                        $projectId
                    );
            }

            /*submitted_at
            signature*/

            /*Below for subcat (Photoview)*/
            if (!empty($project['categories']['damaged_category'][$key]['get_child'])) {
                foreach ($project['categories']['damaged_category'][$key]['get_child'] AS $subKey => $subItem) {
                    if (!empty($subItem['media'])) {
//                        Helper::pd($subItem['media'],'$subItem[\'media\']');
                        $res = ProjectMedia::updateCategoryId_AndMediaTags($subItem['media'], $projectId);
                        if (!empty($res['error'])) {
                            return $this->__sendError($res['error'], $res['error_data'], 400);
                        }
                    }
                }
            }
        }

        if (!empty($project['categories']['additional_photos'])) {
            if (!empty($project['categories']['additional_photos']['media'])) {
                $res = ProjectMedia::updateCategoryId_AndMediaTags($project['categories']['additional_photos']['media'], $projectId);
                if (!empty($res['error'])) {
                    return $this->__sendError($res['error'], $res['error_data'], 400);
                }
            }
        }

        $categories = User::getUserCategories($request->all());
        $project = Project::getCompleteProject($categories, $projectId);


        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $project, 200, 'Project Added Successfully');
    }

    public function updateComplete(Request $request, $projectId)
    {
        $param_rules['project'] = 'required|string';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        $project = json_decode($request['project'], TRUE);

        if(empty($project)){
            return $this->__sendError('Error','Invalid JSON format',400);
        }

        $userDetails = [
            'company_id' => $request['company_id'],
            'user_id' => $request['user_id']
        ];

        $pro = Project::getById($projectId);

        if(empty($pro)){
            return $this->__sendError('Invalid Project Id', ['Can\'t seem to locate project.'],'400');
        }

        Project::updateDetails($projectId, $project, $userDetails);
        Project::updateThumbnail($projectId, $project['project_media']);

        foreach ($project['categories']['required_category'] AS $key => $item) {
            if (!empty($item['deleted_media'])) {
                ProjectMedia::whereIn('id', $item['deleted_media'])->where('project_id', $projectId)->delete();
            }

            if (!empty($item['media'])) {

                $res = ProjectMedia::updateCategoryId_AndMediaTags($item['media'], $projectId);
                if (!empty($res['error'])) {
                    return $this->__sendError($res['error'], $res['error_data'], 400);
                }
            }
        }

        foreach ($project['categories']['damaged_category'] AS $key => $item) {

            if (!empty($item['category_survey'])) {
                $project['categories']['damaged_category'][$key]['category_survey'] =
                $res = ProjectQuery::updateSurvey($item['category_survey'], $projectId);
                if (!empty($res['error'])) {
                    return $this->__sendError($res['error'], $res['error_data'], 400);
                }
            }

            /*Below for subcat (Photoview)*/
            if (!empty($project['categories']['damaged_category'][$key]['get_child'])) {
                foreach ($project['categories']['damaged_category'][$key]['get_child'] AS $subKey => $subItem) {
                    if (!empty($subItem['deleted_media'])) {
                        ProjectMedia::whereIn('id', $subItem['deleted_media'])->where('project_id', $projectId)->delete();
                    }

                    if (!empty($subItem['media'])) {

                        $res = ProjectMedia::updateCategoryId_AndMediaTags($subItem['media'], $projectId);
                        if (!empty($res['error'])) {
                            return $this->__sendError($res['error'], $res['error_data'], 400);
                        }
                    }
                }
            }
        }

//        if (!empty($project['categories']['additional_photos'])) {
//            foreach ($project['categories']['additional_photos'] AS $key => $item) {
//            }
//        }

        if (!empty($project['categories']['additional_photos'])) {
            if (!empty($project['categories']['additional_photos']['deleted_media'])) {
                ProjectMedia::whereIn('id', $project['categories']['additional_photos']['deleted_media'])->where('project_id', $projectId)->delete();
            }

            if (!empty($project['categories']['additional_photos']['media'])) {
                $res = ProjectMedia::updateCategoryId_AndMediaTags($project['categories']['additional_photos']['media'], $projectId);
                if (!empty($res['error'])) {
                    return $this->__sendError($res['error'], $res['error_data'], 400);
                }
            }
        }


        $categories = User::getUserCategories($request->all());
        $project = Project::getCompleteProject($categories, $projectId);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', $project, 200, 'Project Updated Successfully');
    }

    public function imageSync(Request $request)
    {

        $param_rules['image_url'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144|dimensions:min_width=800,min_height=600';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        if ($request->hasFile('image_url')) {
            $imageName = $request['u_id'] . "-" . time() . '_' . rand();
            $request['system_image_url'] = $this->__moveUploadFile(
                $request->file('image_url'),
                $imageName,
                Config::get('constants.MEDIA_IMAGE_PATH')
            );
        }

        $param = $request->all();
        $param['image_path'] = $request['system_image_url'];
        $param['tags'] = json_decode($request['tags'], TRUE);
        ProjectMedia::addImageText_2($param);


        $pMediaCount = ProjectMedia::where(['ref_id' => $request['u_id'], 'category_id' => $request['category_id']])->count();
        if ($pMediaCount > 0) {
            /*Update Media*/
            $id = ProjectMedia::updateUniqueMedia($request['system_image_url'], $request['u_id'], $request['category_id']);
        } else {
            $id = ProjectMedia::createUniqueMedia($request['system_image_url'], $request['u_id'], $request['category_id']);
        }


        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Project', ['media_id' => $id], 200, 'Media uploaded successfully');
    }

    public function mergeReport(Request $request){

        //dd(base_path(config('constants.HOVER_FILE_PATH')));
        $filenames = [
            base_path("public/".config('constants.PDF_PATH'))."project_report_81.pdf",
            base_path("public/".config('constants.HOVER_FILE_PATH'))."23423.pdf",
        ];

        $filesTotal = sizeof($filenames);
        $fileNumber = 1;
        $outFile = base_path("public/".config('constants.HOVER_FILE_PATH'))."merge.pdf";
//        dd(file_exists($outFile));
        // public/uploads/hover/23423.pdf
//        dd($filenames);
//        dd($outFile);

        if (!file_exists($outFile)) {
            $handle = fopen($outFile, 'w');
            fclose($handle);
        }

        $mpdf = new \Mpdf\Mpdf([
//            'mode' => 'utf-8',
            'default_font_size' => 9,
            'default_font_color' => 'white',
            'default_font' => 'axiforma',
            'margin' => 0,
        ]);
//        $mpdf->SetImportUse();

        foreach ($filenames as $fileName) {
            if (file_exists($fileName)) {
                $pagesInFile = $mpdf->SetSourceFile($fileName);

//                if($fileNumber == 2){
//                    $mpdf->AddPage('L');
//                }

                for ($i = 1; $i <= $pagesInFile; $i++) {
                    $tplId = $mpdf->importPage($i); // in mPdf v8 should be 'importPage($i)'

                    $size = $mpdf->getTemplateSize($tplId);
                    $mpdf->AddPage($size['orientation']);

                    dump($size);

                    $mpdf->useTemplate($tplId,0, 0, $size['width'], $size['height'], true);



                    if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {

//                        $mpdf->WriteHTML('<pagebreak />');
                    }
                }
            }
            $fileNumber++;
        }

        $mpdf->Output($outFile);
    }

    public function sampleReport(Request $request){

        //dd(base_path(config('constants.HOVER_FILE_PATH')));
        $filenames = [
            base_path("public/".config('constants.PDF_PATH'))."project_report_81.pdf",
            base_path("public/".config('constants.HOVER_FILE_PATH'))."23423.pdf",
        ];

        $filesTotal = sizeof($filenames);
        $fileNumber = 1;
        $outFile = base_path("public/".config('constants.HOVER_FILE_PATH'))."merge.pdf";
//        dd(file_exists($outFile));
        // public/uploads/hover/23423.pdf
//        dd($filenames);
//        dd($outFile);

        if (!file_exists($outFile)) {
            $handle = fopen($outFile, 'w');
            fclose($handle);
        }

        $mpdf = new \Mpdf\Mpdf([
//            'mode' => 'utf-8',
            'default_font_size' => 9,
            'default_font_color' => 'white',
            'default_font' => 'axiforma',
            'margin' => 0,
        ]);

        $mpdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            0, // margin_left
            0, // margin right
            50, // margin top
            50, // margin bottom
            0, // margin header
            0);

        $mpdf->WriteHTML('
            <table>
            <tr>
                    <td><h1>SIGN TEST FILE</h1></td>


                </tr>
                <tr>
                    <td>TEST</td>
                    <td><input type="text" placeholder="Sign this" name="sign"/></td>

                </tr>
            </table>
        ');

        /**######################## To Save File and then show via URL ########################*/
        $reportPath = public_path(config('constants.PDF_PATH').'hello_test_report.pdf');
        $mpdf->Output($reportPath, 'F');

//        $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'project_report_'.$project['id'].'.pdf');
//        return $reportUrl;

        /** ######################## To real-time output (useful for debugging) ########################*/
//        $mpdf->Output('hello_test_report','I');
    }

    //<editor-fold desc="PDF Report Methods">
    public function reportView (Request $request, $projectId){

        $this->__view = 'subadmin/report_view';

        $data['project_id'] = $projectId;

        //<editor-fold desc="Forwarding user_id of assignee of project (not web-panel id)">
        $project = Project::getById($projectId);
        /** This block is for replacing web-panel admin id with project assignee, since web-panel admin isn't with any company_group_id
         * hence, doesn't have any categories/inspection photos affiliated (Its been done to use same methods as used in API )
         */
        $request['user_id'] = $project['assigned_user_id'];

        $user = User::getById($project['assigned_user_id']);
        $request['company_group_id'] = $user['company_group_id'] ;
        //</editor-fold>

        $data['options'] = CompanyGroupCategory::getCategoriesForReport($request->all());

        //vd($data['options'],'$data[\'options\']');

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $data, 200, 'User list retrieved successfully.');
    }

    public function report (Request $request, $projectId){

        $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'static_doc.pdf');
        return redirect($reportUrl);

        $this->__is_redirect = true;
        $this->__view = 'subadmin/project/reportView/'.$projectId;

        $param_rules['category'] = 'required';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Validation Error', $error['data']);
            return $response;
        }

        $project = Project::getBy(['id' => $projectId ]);

        $request['user_id'] = $project[0]['assigned_user_id'];
        $request['project_id'] = $projectId;

        $whereClauses = ['whereCategory' => $request['category'] ,'whereSurvey' => !empty($request['survey']) ? $request['survey'] : [] ,'whereEstimates' => !empty($request['cost_breakdown']) ? $request['cost_breakdown'] : [] ];

        $reportUrl = $this->generateReport($request->all(),$whereClauses);

        return redirect($reportUrl);

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', [], 200, 'User list retrieved successfully.');
    }

    public function createReport(Request $request, $projectId)
    {
        /** Static Report */
//        die('static');
//        $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'static_doc.pdf');
//        return redirect($reportUrl);

        $user = User::where('token', $request['user-token'])->first();
        if (count((array)$user) < 1) {
            $this->__is_ajax = true;
            return $this->__sendError('This user token is invalid.', [['auth' => 'This user token is invalid.']], 200);
        }

        $request['user_id'] = $user['id'];
        $request['company_id'] = $user['company_id'];
        $request['company_group_id'] = $user['company_group_id'];
        $request['project_id'] = $projectId;

        $param_rules['options'] = 'required|string';
        $param_rules['user_id'] = 'required|int';
        $param_rules['company_id'] = 'required|int';
        $param_rules['company_group_id'] = 'required|int';
        $param_rules['project_id'] = [
            'required',
            'int',
            Rule::exists('project', 'id')->whereNull('deleted_at'),
        ];

        $this->__is_ajax = true;
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true)
            return $response;

        $categories = json_decode($request['options'], TRUE);
        $whereCategory = [];
        $whereSurvey = [];
        $whereEstimates = [];

        $whereClauses = ['whereCategory' => [], 'whereSurvey' => [], 'whereEstimates' => []];
        foreach ($categories AS $key => $item) {
            if ($item['is_selected']) {
                $whereClauses['whereCategory'][] = $item['id'];
            }

            if ($item['survey']) {
                $whereClauses['whereSurvey'][] = $item['id'];
            }

            if ($item['estimates']['selected']) {
                $whereClauses['whereEstimates'][$item['id']] = $item['estimates']['cost_breakdown'];
            }
        }
        $this->generateReport($request->all(),$whereClauses);
    }

    public function generateReport($request,$whereClauses){


        $allCatsParam = [
            'company_id' => $request['company_id'],
            'company_group_id' => $request['company_group_id']
        ];
        $allCats = CompanyGroupCategory::getCategories($allCatsParam, TRUE);
        $request['category_id'] = $whereClauses['whereCategory'];

        $categories = User::getUserCategories($request);
        $project = Project::getCompleteProject($categories, $request['project_id']);
        $project = $project->toArray();

        $project['inspection_date'] = date('Y-m-d', strtotime($project['inspection_date']));

        $mapPath = '';
        if (!empty($project['latitude']) && !empty($project['longitude'])) {
            $mapPath = $this->saveMap($request['project_id'], $project['latitude'], $project['longitude']);
        } else {
            $mapPath = public_path("uploads/map/default_map.png");
        }
//        1161 x 621

        $titles = [
            'additional_photos' => 'Additional Photos',
            'required_category' => 'Included Photos',
            'damaged_category' => 'Inspection Areas',
        ];

        $mpdf = new \Mpdf\Mpdf([
//            'mode' => 'utf-8',
            'default_font_size' => 9,
            'default_font_color' => 'white',
            'default_font' => 'axiforma',
            'margin' => 0,
        ]);
//        $mpdf->SetImportUse();

        $mpdf->SetHTMLHeader(view('reports/project/header', ['project' => $project])->render());
        $typeCount = 0;

        /*Background*/
        $bgPath = base_path('public/assets/images/pdf-bg.png');
        $mpdf->SetDefaultBodyCSS('background', "url('$bgPath')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            0, // margin_left
            0, // margin right
            50, // margin top
            50, // margin bottom
            0, // margin header
            0);

        $mpdf->WriteHTML($this->mapTemplate($mapPath));

        $footer = view('reports/project/footer', []);
        $mpdf->SetHTMLFooter($footer);

        foreach ($project['categories'] AS $typeKey => $typeItem) {

            if (count((array)$project['categories'][$typeKey]) > 0) {
                $mpdf->WriteHTML('<pagebreak />');

                if ($typeKey == 'required_category') {
                    $selectedCatsIds = array_column($project['categories'][$typeKey], 'id');

                    $mpdf->WriteHTML($this->areaTemplate($allCats[$typeKey], $selectedCatsIds, $titles[$typeKey], $mapPath));
                    $mpdf->WriteHTML($this->fourImagesTemplate($project, $project['categories'][$typeKey]));

                    $catEstimates = [];
                    foreach ($project['categories'][$typeKey] AS $mCatKey => $mCatItem) {
                        /*Main Cat*/
                        $project['categories'][$typeKey][$mCatKey]['media_tags'] = 'f';
                        foreach ($project['categories'][$typeKey][$mCatKey]['media'] AS $mediaKey => $mediaItem) {
                            /*Main Media Loop */
                            $media = $project['categories'][$typeKey][$mCatKey]['media'][$mediaKey];

                            if (!empty($media['media_tags_extended'])) {
                                /*IF TAGS IN MEDIA */
                                $project['categories'][$typeKey][$mCatKey]['media_tags'] = 't';

                                /**
                                 * ESTIMATES 1
                                 * */


                                //<editor-fold desc="If Category is selected for estimates">
                                if (in_array($mCatItem['id'], array_keys($whereClauses['whereEstimates']))) {

                                    /*preparing Report Estimate Data*/
                                    $mediaTagsExt = $project['categories'][$typeKey][$mCatKey]['media'][$mediaKey]['media_tags_extended'];

                                    foreach ($mediaTagsExt AS $tagKey => $mTagItem) {

                                        $tagId = $mTagItem['tag_id'];


                                        /** 19-Jun-21 This entire section can be removed since these arrays are  already merging at "app/Models/Project.php:317" (but with different columns)*/
                                        //<editor-fold desc="Merging 'category_tags' and selected tags 'media_tags_extended' ">
                                        $catTagsCollection = collect($project['categories'][$typeKey][$mCatKey]['category_tags']);

                                        $subCatTagDetails = $catTagsCollection->first(function ($item) use ($tagId) {
                                            return $item['id'] == $tagId;
                                        });

                                        $project['categories'][$typeKey][$mCatKey]['media'][$mediaKey]['media_tags_extended'][$tagKey]['has_qty'] = $subCatTagDetails['has_qty'];

                                        if(!empty($subCatTagDetails)){
                                            $catEstimates[$mCatKey]['inspectionArea'] = $mCatItem['category_name'];
                                            $catEstimates[$mCatKey]['project_sales_tax'] = $project['sales_tax'];
                                            $catEstimates[$mCatKey]['cost_breakdown'] = $whereClauses['whereEstimates'][$mCatItem['id']];

                                            if (!empty($catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']])) {
                                                $catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']]['selected_qty'] += $mTagItem['selected_qty'];
                                            } else {

                                                $catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']] = array_collapse([
                                                    array_only($subCatTagDetails, ['id', 'company_id','has_qty', 'ref_id', 'ref_type', 'name', 'annotation',
                                                        'price', 'uom', 'material_cost', 'labor_cost', 'equipment_cost', 'supervision_cost',
                                                        'margin']),
                                                    array_except($mTagItem, ['target_id', 'target_type', 'created_at', 'company_id'])
                                                ]);
                                            }
                                        }
                                        //</editor-fold>
                                    }
                                }
                                //</editor-fold>
                            }
                        }/*Media loop ends*/

                        $project['categories'][$typeKey][$mCatKey]['get_child'] = '';
                    }

                    //<editor-fold desc="Estimates Rendering">
                    if (!empty($catEstimates)) {
                        $mpdf->WriteHTML('<pagebreak/>');
                        $mpdf->WriteHTML($this->estimatesTemplate($catEstimates));
                    }
                    //</editor-fold>

//                    $mpdf->WriteHTML('<pagebreak />');
//                    $mpdf->WriteHTML($this->componentTemplate($project['categories'][$typeKey]));
                } else if ($typeKey == 'damaged_category') {

                    $selectedCatsIds = array_column($project['categories'][$typeKey], 'id');

                    $mpdf->WriteHTML($this->areaTemplate($allCats[$typeKey], $selectedCatsIds, $titles[$typeKey], $mapPath));
                    $mpdf->WriteHTML($this->fourImagesTemplate($project, $project['categories'][$typeKey]));
                    $mpdf->WriteHTML('<pagebreak />');
                    $mpdf->WriteHTML($this->surveyTemplate($project['categories'][$typeKey], $whereClauses['whereSurvey']));
//                    $mpdf->WriteHTML('<pagebreak />');

                    $catEstimates = [];

                    //<editor-fold desc="Main Cat">
                    foreach ($project['categories'][$typeKey] AS $mCatKey => $mCatItem) {
                        //echo('category_name: '.$mCatItem['category_name']);

                        $project['categories'][$typeKey][$mCatKey]['media_tags'] = 'f';
                        /*Sub Cat*/
                        foreach ($project['categories'][$typeKey][$mCatKey]['get_child'] AS $subCatKey => $subCatItem) {
                            //echo('<br><br>_____sub_category_name: '.$subCatItem['name']);

                            $project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media_tags'] = 'f';

                            if (!empty($project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media'])) {
                                //echo "<br> Media";

                                foreach ($project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media'] AS $subMediaKey => $subMediaItem) {

                                    /*Sub Cat Media*/
                                    if (!empty($project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media'][$subMediaKey]['media_tags_extended'])) {
                                        //echo "<br> Media Tags";
                                        /*IF TAGS IN MEDIA */
                                        $project['categories'][$typeKey][$mCatKey]['media_tags'] = 't';
                                        $project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media_tags'] = 't';


                                        /**
                                         * ESTIMATES 2
                                         * */


                                        /** If Cat is selected for estimates*/
                                        if (in_array($mCatItem['id'], array_keys($whereClauses['whereEstimates']))) {

                                            $mediaTagsExt = $project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media'][$subMediaKey]['media_tags_extended'];

                                            //<editor-fold desc="preparing Report Estimate Data">
                                            foreach ($mediaTagsExt AS $tagKey => $mTagItem) {

                                                $tagId = $mTagItem['tag_id'];

                                                /** 19-Jun-21 This entire section can be removed since these arrays are  already merging at "app/Models/Project.php:317" (but with different columns)*/
                                                //<editor-fold desc="Merging 'category_tags' and selected tags 'media_tags_extended' ">
                                                $subCatTagsCollection = collect($project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['category_tags']);
                                                $subCatTagDetails = $subCatTagsCollection->first(function ($item) use ($tagId) {
                                                    return $item['id'] == $tagId;
                                                });


                                                $project['categories'][$typeKey][$mCatKey]['get_child'][$subCatKey]['media'][$subMediaKey]['media_tags_extended'][$tagKey]['has_qty'] = $subCatTagDetails['has_qty'];

                                                if(!empty($subCatTagDetails)){

                                                    $catEstimates[$mCatKey]['inspectionArea'] = $mCatItem['category_name'];
                                                    $catEstimates[$mCatKey]['project_sales_tax'] = $project['sales_tax'];
                                                    $catEstimates[$mCatKey]['cost_breakdown'] = $whereClauses['whereEstimates'][$mCatItem['id']];

                                                    if (!empty($catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']])) {
                                                        /** IF same tag exists add to 'selected_qty' */
                                                        $catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']]['selected_qty'] += $mTagItem['selected_qty'];
                                                    } else {
                                                        /** IF new tag append to dataset */
                                                        $catEstimates[$mCatKey]['tags'][$mTagItem['tag_id']] = array_collapse([
                                                            array_only($subCatTagDetails, ['id', 'company_id', 'ref_id', 'ref_type', 'name','annotation',
                                                                'price', 'uom', 'material_cost', 'labor_cost', 'equipment_cost', 'supervision_cost',
                                                                'margin']),
                                                            array_except($mTagItem, ['target_id', 'target_type', 'created_at', 'company_id'])
                                                        ]);
                                                    }
                                                }
                                                //</editor-fold>
                                            }
                                            //</editor-fold>
                                        }
                                    }
                                }/*Media Loop*///
                            }
                        }/*Sub Cat Loop*/
                    }/*Main Cat Loop*/
                    //</editor-fold>

                    //<editor-fold desc="Estimates Rendering">
                    if (!empty($catEstimates)) {
                        $mpdf->WriteHTML($this->estimatesTemplate($catEstimates));
                        $mpdf->WriteHTML('<pagebreak />');
                    }
                    //</editor-fold>

                    $mpdf->WriteHTML($this->componentTemplate($project['categories'][$typeKey]));
                } else {

                    //<editor-fold desc="Additional Photos Block">
                    $selectedCatsIds = array_column([$project['categories'][$typeKey]], 'id');
                    $mpdf->WriteHTML($this->areaTemplate([$allCats[$typeKey]], $selectedCatsIds, $titles[$typeKey], $mapPath));
                    $hasTags = false;
                    if (!empty($project['categories'][$typeKey]['media'])) {

                        $mpdf->WriteHTML($this->fourImagesTemplate($project, [$project['categories'][$typeKey]]));
                        foreach ($project['categories'][$typeKey]['media'] AS $mMediaKey => $mMediaItem) {
                            if (!empty($mMediaItem['media_tags_extended'])) {
                                $hasTags = true;
                            }
                        }
                    } else {
                        $mpdf->WriteHTML('
                        <table style="width:100%; padding:0px 50px;">
                            <tr>
                                <td style="text-align: center;">
                                    <h4> No additional photos </h4>
                                </td>
                            </tr>
                        </table> ');
                    }
                    if(!empty($hasTags)){
                        $mpdf->WriteHTML('<pagebreak />');
                        $mpdf->WriteHTML($this->componentTemplate([$project['categories'][$typeKey]]));
                    }
                    //</editor-fold>
                }

                if(count(((array) $project['categories']))  == $typeCount){
                    $mpdf->WriteHTML('<pagebreak />');
                }
                $typeCount++;
            }
        }/*FOR EACH*/

        $mpdf->SetTitle($project['name']);

        /**######################## To Save File and then show via URL ########################*/
//        $reportPath = public_path(config('constants.PDF_PATH').'project_report_'.$project['id'].'.pdf');
//        $mpdf->Output($reportPath, 'F');
//        $reportUrl = (env('BASE_URL').config('constants.PDF_PATH').'project_report_'.$project['id'].'.pdf');
//
//        return $reportUrl;
//        die($reportUrl);
//        return redirect($reportUrl);


        /** ######################## To real-time output (useful for debugging) ########################*/
        $mpdf->Output($project['id'], 'I');
    }

    /*New 4 Images template*/
    public function fourImagesTemplate($project, $category)
    {
        $html = '';
        if (/*FALSE*/ TRUE ) {
            foreach ($category AS $mainKey => $item) {
                $category[$mainKey]['media_count'] += count(((array) $item['media']));

                /**
                 * CHILD
                 **/

                if (!empty($category[$mainKey]['get_child']) /*FALSE*/) {
                    foreach ($category[$mainKey]['get_child'] AS $subKey => $subItem) {
                        $category[$mainKey]['get_child'][$subKey]['media_count'] += count(((array) $subItem['media']));
                    }
                }
            }
        }

        $html .= view('reports/project/four_images', ['category' => $category])->render();
        return $html;
    }

    public function twoImagesTemplate($project, $category)
    {
        $html = '';
        $count = 0;
        $catDetails = [];
        $media = [];
        $mediaCount = 0;

        //<editor-fold desc="Main Categories">
        foreach ($category AS $mainKey => $item) {
            $catDetails['area'] = $item['category_name'];

            //<editor-fold desc="Main Categories Media Block">
            if (count(((array) $item['media']) > 0)) {
                foreach ($item['media'] AS $mediaKey => $mediaItem) {

                    $media[] = [
                        'media' => $mediaItem,
                        'category' => $catDetails,
                    ];

                    $mainMediaTags = '';
                    foreach ($mediaItem['media_tags_extended'] AS $mediaTagkey => $mediaTagItem) {
                        if ($mediaTagItem['has_qty'] > 0) {
                            $mainMediaTags .= $mediaTagItem['name'] . "(" . $mediaTagItem['selected_qty'] . "), ";
                        } else {
                            $mainMediaTags .= $mediaTagItem['name'] . ", ";
                        }
                    }

                    $imagesData = [
                        'media' => $mediaItem,
                        'category' => $catDetails,
                        'totalMedia' => count(((array) $item['media'])),
                        'current' => $mediaKey + 1,
                        'mediaTags' => $mainMediaTags
                    ];

                    /** iterate this on php level (And not on blade) cuz of php variables issues and header template*/
                    $html .= view('reports/project/images', $imagesData)->render();
                    $mediaCount++;

                    $count++;
                    if ($count == 2) {
                        $count = 0;
                    }
                }
            }
            //</editor-fold>

            //<editor-fold desc="Child Categories Block">
            if (!empty($category[$mainKey]['get_child'])) {
                foreach ($category[$mainKey]['get_child'] AS $subKey => $subItem) {
                    $catDetails['photo_view'] = $category[$mainKey]['get_child'][$subKey]['name'];

                    if (count(((array) $subItem['media'])) > 0) {

                        foreach ($subItem['media'] AS $mediaKey => $mediaItem) {

                            $media[] = [
                                'media' => $mediaItem,
                                'category' => $catDetails,
                            ];

                            $subMediaTags = '';
                            foreach ($mediaItem['media_tags_extended'] AS $mediaTagKey => $mediaTagItem) {
                                if ($mediaTagItem['has_qty'] > 0) {
                                    $subMediaTags .= $mediaTagItem['name'] . "(" . $mediaTagItem['selected_qty'] . "), ";
                                } else {
                                    $subMediaTags .= $mediaTagItem['name'] . ", ";
                                }
                            }

                            $imagesData = [
                                'media' => $mediaItem,
                                'category' => $catDetails,
                                'totalMedia' => count(((array) $subItem['media'])),
                                'current' => $mediaKey + 1,
                                'mediaTags' => $subMediaTags
                            ];
                            /*iterate this on php level (And not on blade) cuz of php variables issues and header template*/
                            $html .= view('reports/project/images', $imagesData)->render();
                            $mediaCount++;

                            $count++;
                            if ($count == 2) {
                                $count = 0;
                            }
                        }
                    }
                }
            }
            //</editor-fold>
        }
        //</editor-fold>

        $mediaOdd = ($mediaCount % 2) > 0 ? 1 : 0;

        return $html;
    }

    public function areaTemplate($categories, $selectedCategories, $title, $mapPath)
    {
        $html = '';
        $html .= view('reports/project/areas', ['categories' => $categories, 'selectedCategories' => $selectedCategories, 'title' => $title, 'map' => $mapPath])->render();
        return $html;
    }

    public function surveyTemplate($category, $whereSurvey = [])
    {
        $html = '';
        foreach ($category AS $cKey => $cItem) {
            if (in_array($cItem['id'], $whereSurvey)) {
                $data = [
                    'survey' => $cItem['survey'],
                    'category_name' => $cItem['category_name'],
                ];
                $html .= view('reports/project/query', $data);
                $html .= "<pagebreak />";
            }
        }
        return $html;
    }

    public function estimatesTemplate($data){

        return view('reports/project/estimates', ['estimates'=> $data]);
    }

    public function componentTemplate($categories)
    {

        $view = view('reports/project/component', ['categories' => $categories])->render();
        return $view;
    }



    public function saveMap($projectId, $lat, $long)
    {

        $mapPath = public_path("uploads/map/map_{$projectId}.jpg");
        $res = copy("https://maps.googleapis.com/maps/api/staticmap?zoom=18&size=800x443&maptype=satellite&markers=color:red|label:location|$lat,$long&key=AIzaSyAlUlyus8U80FZOXPzVHEeVEYHcJHsOrjU", $mapPath);
        if(!$res){
            die('map failed');
        }
        return $mapPath;
    }

    public function mapTemplate($mapImage)
    {
        return view('reports/project/map', ['map' => $mapImage])->render();
    }

    public function pdf()
    {
        $pdf = PDF::loadView('reports/project/report', '', [], [
            'title' => 'Another Title',
            'margin_top' => 0
        ]);
        return $pdf->stream('document.pdf');
    }
    //</editor-fold>

    public function __edit_project(Request $request,$id){

        $project = Project::getById($id);

        $catWhere = [
            'company_id' => $request['company_id'],
            'company_group_id' => $project->assigned_user->company_group_id,
        ];
        $categories = CompanyGroupCategory::getCategories($catWhere, TRUE);
        $completeProject = Project::getCompleteProject($categories, $id);

        return view('subadmin/edit_project', ['project' => $completeProject->toArray()]);
    }
}

