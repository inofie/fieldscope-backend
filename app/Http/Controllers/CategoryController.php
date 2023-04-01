<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Helper;
use App\Libraries\Payment\BrainTree;
use App\Models\Company;
use App\Models\Category;
use App\Models\CompanyGroup;
use App\Models\CompanyGroupCategory;
use App\Models\Notification;
use App\Models\Query;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Tag;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Couchbase\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    function __construct(){

        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
            'store','storeGroup', 'index', 'show', 'edit', 'update',  'getSetting'
            , 'profile', 'updateSetting', 'updateLocation', 'userSubscription', 'subscription',
            'increaseDealQuota', 'addCompanyDonation' , 'paymentProcess', 'tenantUserList', 'areaList','storeArea','editArea','updateArea',
            'photoViewList' , 'storePhotoView','requirePhotoList','storeRequirePhoto', 'getReportOptions' ]
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        Helper::pd($request->all());
        $param['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
        $param['parent_id'] = isset($request['category_id']) ? $request['category_id'] : 0;
        $param['company_id'] = isset($request['company_id']) ? $request['company_id'] : NULL;
        $param['paginate'] = false;

        $user = User::where('id',$request['user_id'])->get();
        $param['company_group_id'] = isset($user[0]['company_group_id']) ? $user[0]['company_group_id'] : NULL;

//        Helper::p($param);
        $list = CompanyGroupCategory::getCategories($param ,TRUE);
//        pd($list,'$list');

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('CategoryAll', $list, 200,'Category list retrieved successfully.');
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function areaList(Request $request)
    {
//        echo "<pre>"; print_r($request->all()); die;
        $this->__view = 'subadmin/inspect-area_mgmt';

        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $list['categories'] = Category::getCategoryList_withGroupedCompanyGroup($param);
        $list['companyGroups'] = CompanyGroup::where('company_id',$request->company_id)->get();
//        dd($list['categories']->toArray());
//        dd($list['companyGroups']->toArray());

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function areaDatatable(Request $request){

        // search params
        $param = $request->all();
        $param['column_index'] = $param['order'][0]['column'];
        $param['sort'] = $param['order'][0]['dir'];

        $records["data"] = array();
        //get records for datatable

        if(!empty($param['reOrder'])){
            Log::info('areaDatatable: ',$param);
            $reOrderRes = Category::reOrder($param['reOrder'],$param['company_id'],$param['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $param['parent_id'] = 0;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $dataTableRecord = Category::areaDatatable($param);

        //<editor-fold desc="set data grid output">
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'])))
        {
            foreach($dataTableRecord['records'] as $record){

//                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
//                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" data-module="inspect_area" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $records["data"][] = [
                    'id' => $record->id,
                    'name' => $record->name,
                    'type' => ($record->type == 1) ? 'Required': 'Inspection Photos',
                    'company_group_titles' => !empty($record->company_group_titles) ? $record->company_group_titles : 'N.A' ,
                    'order_by' => $record->order_by,
                ];
            }
        }
        //</editor-fold>

        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function storeArea(Request $request)
    {

        $this->__view = 'subadmin/inspect_area';
        $this->__is_redirect = true;
        $param_rules['company_id'] = 'required|int' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $param_rules['company_group_id.0'] = 'required' ;

        $messages = [
            'company_group_id.0.required' => 'User Type is required',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules,$messages);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $maxCat = Category::where(['company_id' => $request->company_id , 'parent_id' => 0 , 'type' => 2 ])->max('order_by');

        $category = new Category();
        $category->name = $request->name;
        $category->type = 2;
        $category->order_by = !empty($maxCat) ? (int)$maxCat+1 : 1;
        $category->company_id = $request->company_id;
        $category->parent_id = 0;

        if(!$category->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $data = [];
        foreach ($request['company_group_id'] AS $item){
            $data[] = [
                'company_id'    => $request['company_id'],
                'category_id'   => $category->id,
                'company_group_id'  => $item,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        $result = CompanyGroupCategory::insert($data);

        if(!$result){
            $error['data'][0] = "Add failed CompanyGroupCategory ";
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        //$list = Category::getById($category->id);
        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    public function editArea (Request $request, $id){
        $param['parent_id'] = 0;
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Category::where($param)->first();

        $param['parent_id'] = 0;
        $param['company_id'] = $request['company_id'];
        $param['category_id'] = $id;
//        Helper::p($param );
        $cP = CompanyGroupCategory::getByCategoryId($param);;
        $list['company_group'] = $cP->toArray();
//        Helper::pd($cP->toArray() );

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');
    }

    public function updateArea (Request $request, $id){
        $this->__view = 'subadmin/inspect_area?page='.$request['page'];
        $this->__is_redirect = true;
        $param_rules['company_id'] = 'required|int' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $param_rules['company_group_id.0'] = 'required' ;

        $messages = [
            'company_group_id.0.required' => 'User Type is required',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules, $messages);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $category = new Category();
        $cat = $category::find($id);
        $cat->name = $request['name'];
        $cat->name = $request['name'];
        $cat->order_by = $request['order_by'];
        if(!$cat->save()){
            return $this->__sendError('Query Error','Unable to Update record.' );
        }

        $d = CompanyGroupCategory::where([
            'company_id'    => $request['company_id'],
            'category_id'   => $cat->id,
        ])->forceDelete();


        $data = [];
        foreach ($request['company_group_id'] AS $item){
            $data[] = [
                'company_id'    => $request['company_id'],
                'category_id'   => $cat->id,
                'company_group_id'  => $item,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        $result = CompanyGroupCategory::insert($data);
//        Helper::pd($result );
        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    public function deleteArea (Request $request, $id){

        $delRes = Category::deleteArea_withChild($id);

        if(!$delRes){
            $error['data'][0] = "Delete Failed ";
            return $this->__sendError('Query Error','Unable to Delete record.' );
        }

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Category', [], 200,'Deleted successfully.');
    }

    public function photoViewList (Request $request){
        //        echo "<pre>"; print_r($request->all()); die;
        $this->__view = 'subadmin/photo-view_mgmt';

//        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $list['categories'] = Category::getSubCategory_withParents($param);

        $where= [
            'company_id' => $request->company_id,
            'parent_id' => 0,
            'type' => 2
        ];
        $list['area'] = Category::where($where)->get();

        $list['thumbnailCount'] = Category::where(['company_id' => $request['company_id'], 'thumbnail' => 1])->count();

//        pd($thumbnailCount,'$thumbnailCount');


        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function photoViewDatatable (Request $request){
        // search params
        $param = $request->all();
        $param['column_index'] = $param['order'][0]['column'];
        $param['sort'] = $param['order'][0]['dir'];

        $records["data"] = array();
        //get records for datatable
        $param['parent_id'] = 0;

        if(!empty($param['reOrder'])){
            $reOrderRes = Category::reOrder($param['reOrder'],$param['company_id'],$param['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $dataTableRecord = Category::photoViewDatatable($param);


        //<editor-fold desc="set data grid output">
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'])))
        {
            foreach($dataTableRecord['records'] as $record){

//                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  data-id="'.$record->category2_id.'"><i class="fa fa-edit"></i> </a>';
//                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" data-module="photo_view" data-id="'.$record->category2_id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $records["data"][] = [
                    'id' => $record->category2_id,
                    'name' => $record->category2_name,
                    'parent' => $record->category1_name,
                    'min_quantity' => $record->category2_min_quantity,
                    'thumbnail' => ((int) $record->category2_thumbnail) > 0 ? 'YES': "NO" ,
                    'order_by' => $record->order_by
                ];
            }
        }
        //</editor-fold>

        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function storePhotoView (Request $request){
        $this->__view = 'subadmin/photo_view';
        $this->__is_redirect = true;

        $param_rules['company_id'] = 'required|int' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $param_rules['parent_id'] = 'required|string|max:100' ;
        $param_rules['thumbnail'] = 'nullable|in:0,1' ;
        $param_rules['min_quantity'] = 'required|int|min:1' ;
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $maxCat = Category::where(['company_id' => $request->company_id , 'type' => 2 ])->whereNotNull('parent_id')->max('order_by');

        $category = new Category();

        $category->name = $request->name;
        $category->type = 2;
        $category->order_by = !empty($maxCat) ? (int)$maxCat+1 : 1;
        $category->thumbnail = !empty($request->thumbnail) ? $request->thumbnail : 0;
        $category->company_id = $request->company_id;
        $category->parent_id = $request->parent_id;
        $category->min_quantity = $request->min_quantity;

        if(!$category->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $where = [
            'company_id' => $request->company_id,
            'category_id' => $request->parent_id
        ];

        $parentCat = Category::getCategory_withCompanyGroup($where);

        $data = [
            'company_id'    => $request['company_id'],
            'category_id'   => $category->id,
            'company_group_id'  => $parentCat[0]['company_group_id'],
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $result = CompanyGroupCategory::firstOrCreate($data);


        if(!$result){
            $error['data'][0] = "Add failed CompanyGroupCategory ";
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        //$list = Category::getById($category->id);
        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    public function editPhotoView (Request $request, $id ){
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Category::where($param)->first();

//        $list['parent_cat'] = Category::where('parent_id',$id)->get();

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');
    }

    public function updatePhotoView (Request $request, $id ){
        $this->__view = 'subadmin/photo_view?page='.$request['page'];
        $this->__is_redirect = true;

        $param_rules['company_id'] = 'required|int' ;
        $param_rules['parent_id'] = 'required|int' ;
        $param_rules['thumbnail'] = 'nullable|in:0,1' ;
        $param_rules['min_quantity'] = 'required|int|min:1' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $category = new Category();
        $cat = $category::find($id);
        $cat->name = $request['name'];
        $cat->order_by = $request['order_by'];
        $cat->thumbnail = !empty($request->thumbnail) ? $request->thumbnail : 0;
        $cat->parent_id = $request['parent_id'];
        $cat->min_quantity = $request['min_quantity'];
        if(!$cat->save()){
            return $this->__sendError('Query Error','Unable to Update record.' );
        }

        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    public function deletePhotoView (Request $request, $id){
        /*not getting used*/
        $this->__view = 'subadmin/photo_view?page='.$request['page'];
        $this->__is_redirect = true;

        $d = Category::where('id',$id)->delete();
        if(!$d){
            $error['data'][0] = "Delete Failed ";
            $this->__setFlash('danger','Not Delete Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to Delete record.' );
        }
        $this->__setFlash('success', 'Deleted Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category deleted successfully.');
    }

    /*Require Photos Start*/

    public function requirePhotoList(Request $request)
    {
//        echo "<pre>"; print_r($request->all()); die;
        $this->__view = 'subadmin/req-photo_mgmt';

        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 1;
        $param['keyword'] = $request['keyword'];
        $list['categories'] = Category::getCategoryList_withGroupedCompanyGroup($param);
        $list['companyGroups'] = CompanyGroup::where('company_id',$request->company_id)->get();


        $list['thumbnailCount'] = Category::where(['company_id' => $request['company_id'], 'thumbnail' => 1])->count();

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function requirePhotoDatatable (Request $request){
        $param = $request->all();
//        Helper::p($param,'$param');
        $param['column_index'] = $param['order'][0]['column'];
        $param['sort'] = $param['order'][0]['dir'];

        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 1;
        $param['keyword'] = $request['keyword'];

        if(!empty($param['reOrder'])){
            $reOrderRes = Category::reOrder($param['reOrder'],$param['company_id'],$param['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $dataTableRecord = Category::areaDatatable($param);

        // set data grid output
        $records["data"] = [];
        if(count(((array) $dataTableRecord['records'])))
        {

            foreach($dataTableRecord['records'] as $record){
                $options  = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  
                data-id="'.$record->id.'"><i class="fa fa-edit"></i> </a>';
                $options .= '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" 
                data-module="require_photo" data-id="'.$record->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';

                $records["data"][] = [
                    'id' => $record->id,
                    'name' => $record->name,
                    'type' => ($record->type == 1) ? 'Required': 'Inspection Photos',
                    'company_group_titles' => $record->company_group_titles,
                    'min_quantity' => $record->min_quantity,
                    'thumbnail' => ((int) $record->thumbnail) > 0 ? 'YES': "NO" ,
                    'order_by' => $record->order_by,
                ];
            }
        }
        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function storeRequirePhoto (Request $request){
        $this->__view = 'subadmin/require_photo';
        $this->__is_redirect = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;

//        Helper::pd($request->all(),'$request');
        $param_rules['company_id'] = 'required|int' ;
        $param_rules['company_group_id'] = 'required' ;
        $param_rules['thumbnail'] = [
            'nullable',
            Rule::in([0, 1]),

        ];
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['min_quantity'] = 'required|int|min:1' ;


        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $response;
        }

        /*Thumbnail Check Validation*/
        $thumbCount = Category::where([
            'type' => 1,
            'company_id' => $request['company_id']
        ])->where('thumbnail', '=', 1)->count();

//        Helper::pd($thumbCount,'$thumbCount');

        if($thumbCount > 0 && $request['thumbnail'] > 0){
            $this->__setFlash('danger','Not Updated Successfully' , ['Already has default thumbnail']);
            return $this->__sendResponse('Category', [], 200,'Category updated successfully.');
        }


        /*Inserting to db*/
        $maxCat = Category::where(['company_id' => $request->company_id , 'parent_id' => 0 , 'type' => 1 ])->max('order_by');

        $category = new Category();
        $category->name = $request->name;
        $category->type = 1;
        $category->thumbnail = !empty($request->thumbnail) ? $request->thumbnail: 0;
        $category->min_quantity = $request->min_quantity;
        $category->order_by = !empty($maxCat) ? (int)$maxCat+1 : 1;
        $category->company_id = $request->company_id;
        $category->parent_id = 0;

        if(!$category->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $data = [];
        foreach ($request['company_group_id'] AS $item){
            $data[] = [
                'company_id'    => $request['company_id'],
                'category_id'   => $category->id,
                'company_group_id'  => $item,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        $result = CompanyGroupCategory::insert($data);

        if(!$result){
            $error['data'][0] = "Add failed CompanyGroupCategory ";
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $this->__setFlash('success', 'Added Successfully');
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    public function editRequirePhoto (Request $request, $id){

        $param['parent_id'] = 0;
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Category::where($param)->first();

        $param['parent_id'] = 0;
        $param['company_id'] = $request['company_id'];
        $param['category_id'] = $id;
//        Helper::p($param );
        $cP = CompanyGroupCategory::getByCategoryId($param);;
        $list['company_group'] = $cP->toArray();
//        Helper::pd($cP->toArray() );

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Company Group list retrieved successfully.');
    }

    public function updateRequirePhoto (Request $request, $id){
        $this->__view = 'subadmin/require_photo?page='.$request['page'];
        $this->__is_redirect = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;

        $vParam = $request->all();

        $param_rules['company_id'] = 'required|int' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $param_rules['thumbnail'] = [
            'nullable',
            Rule::in([0, 1]),
        ];
        $param_rules['min_quantity'] = 'required|int|min:1' ;
        $param_rules['company_group_id'] = 'required' ;


        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        /*Thumbnail Check Validation*/
        $thumbCount = Category::where([
            'type' => 1,
            'company_id' => $request['company_id']
        ])->where([['thumbnail', '=', 1] , ['id', '<>', $id ]])->count();

        if($thumbCount > 0 && $request['thumbnail'] > 0){
            $this->__setFlash('danger','Not Updated Successfully' , ['Already has default thumbnail']);
            return $this->__sendResponse('Category', [], 200,'Category updated successfully.');
        }

        /*Updating to db*/
        $category = new Category();
        $cat = $category::find($id);
        $cat->name = $request['name'];
        $cat->thumbnail = $request->thumbnail;
        $cat->min_quantity = $request['min_quantity'];
        $cat->order_by = $request['order_by'];
        if(!$cat->save()){
            return $this->__sendError('Query Error','Unable to Update record.' );
        }

        $d = CompanyGroupCategory::where([
            'company_id'    => $request['company_id'],
            'category_id'   => $cat->id,
        ])->forceDelete();


        $data = [];
        foreach ($request['company_group_id'] AS $item){
            $data[] = [
                'company_id'    => $request['company_id'],
                'category_id'   => $cat->id,
                'company_group_id'  => $item,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        $result = CompanyGroupCategory::insert($data);
//        Helper::pd($result );
        $this->__setFlash('success', 'Updated Successfully');

        return $this->__sendResponse('Category', [], 200,'Category updated successfully.');
    }

    public function deleteRequirePhoto (Request $request, $id){
//        $this->__view = 'subadmin/require_photo?page='.$request['page'];
//        $this->__is_redirect = true;

        $d = Category::where('id',$id)->delete();
        if(!$d){
            $error['data'][0] = "Delete Failed ";
            $this->__setFlash('danger','Not Delete Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to Delete record.' );
        }

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', [], 200,'Category added successfully.');
    }

    /*Require Photos End*/


    public function store(Request $request)
    {
        $param_rules['company_id'] = 'required|int' ;
        $param_rules['name'] = 'required|string|max:100' ;
        $param_rules['parent_id'] = 'nullable|int' ;
        $param_rules['min_quantity'] = 'nullable|int' ;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $category = new Category();

        $category->name = $request->name;
        $category->company_id = $request->company_id;
        $category->parent_id = !empty($request->parent_id) ? $request->parent_id : 0;

        if($request->parent_id > 0 ){
            $category->min_quantity = $request->min_quantity;
        }

        if(!$category->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $list = Category::getById($category->id);


        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', $list, 200,'Category added successfully.');
    }

    public function storeGroup(Request $request){

//        print_r($request); die;
        $param_rules['company_id'] = 'required|int' ;
        $param_rules['category_id'] = 'required|string|max:100' ;
        $param_rules['company_group_id'] = 'required|int' ;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $cGroupCat = new CompanyGroupCategory();

        $cGroupCat->company_id = $request['company_id'];
        $cGroupCat->category_id = $request['category_id'];
        $cGroupCat->company_group_id = $request['company_group_id'];

        if(!$cGroupCat->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $list = CompanyGroupCategory::getByCategoryId($request->all());

        $this->__is_paginate = false;
        $this->__is_collection = false;

        return $this->__sendResponse('Category', $list[0], 200,'Category Group assigned successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $param_rules['id'] = 'required|exists:user';

        $response = $this->__validateRequestParams(['id' => $request['user_id']], $param_rules);

        if($this->__is_error == true)
            return $response;

        $this->__is_paginate = false;
        return $this->__sendResponse('User', User::getById($request['user_id']), 200,'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request['id'] = $id;

        $param_rules['id']              = 'required|int|' ;
        $param_rules['company_id']      = 'required|int' ;
        $param_rules['name']            = 'required|string|max:100' ;
        $param_rules['parent_id']       = 'nullable|int' ;
        $param_rules['min_quantity']    = 'nullable|int' ;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $category = Category::find($id);
        $category->name = $request->name;
        $category->company_id = $request->company_id;
        $category->parent_id = !empty($request->parent_id) ? $request->parent_id : 0;

        if(!$category->save()){
            return $this->__sendError('Query Error','Unable to add record.' );
        }

        $list = Category::getById($category->id);

        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Category', $list, 200,'Category updated successfully.');

    }

    public function delete(Request $request, $id){

        $request['id'] = $id;
        $param_rules['id'] = 'required|int|' ;

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if($this->__is_error == true)
            return $response;

        $childs = Category::where('parent_id',$id)->get()->toArray();
        //dd();
        if(count(((array) $childs)) > 0 ){
            Category::destroy(array_column($childs,'id'));
        }

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', [], 200,'Category deleted successfully.');
    }

    public function getReportOptions(Request $request){

        $options = CompanyGroupCategory::getCategoriesForReport($request->all());

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('CategoryAll', $options, 200, 'Option list retrieved successfully.');
    }

    public function getPhotoView(Request $request,$parentId)
    {
        $this->__is_ajax = true;

        //<editor-fold desc="Validation">
        $request['parent_id'] = $parentId;
        $param_rules['parent_id'] = [
            'required', Rule::exists('category','parent_id')->where(function($q){
                $q->whereNull('deleted_at');
            }),
        ];
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if($this->__is_error == true)
            return $response;
        //</editor-fold>

        $photoViews = Category::where(['parent_id' => $parentId])->get(['id','name']);

        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Category', $photoViews, 200,'Photoview retrieved successfully.');
    }



}
