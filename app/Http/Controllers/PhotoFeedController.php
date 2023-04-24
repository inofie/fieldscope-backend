<?php

namespace App\Http\Controllers;

use App\Exports\TagExport;
use App\Http\Middleware\LoginAuth;
use App\Models\Project;
use App\Models\Category;
use App\Models\ProjectMedia;
use App\Models\ProjectMediaTag;
use App\Models\Sticker;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhotoFeedController extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
                'store', 'index', 'show', 'edit', 'update', 'details'
                 ]
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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

    public function listView(Request $request){

        $this->__view = 'subadmin/photo_feed_list';

        $projects = Project::selectRaw('id,name')->where(['company_id' => $request['company_id']])->get();
        $user = User::selectRaw('id,first_name,last_name')->where(['company_id' => $request['company_id']])->whereNotNull('company_group_id')->get();
        $tag = Tag::selectRaw('id,name')->where(['company_id' => $request['company_id']])->get();

        $data['projects'] = $projects;
        $data['user'] = $user;
        $data['tag'] = $tag;
        $data['latest_photos'] = ProjectMedia::getLatestPhotos($request->all());
//        pd($data['latest_photos']->toArray(),'$data[\'latest_photos\']');

        $request->request->remove('company_id');
        $request->request->remove('call_mode');
        $request->request->remove('user_id');

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        $headers = [
            'Cache-Control' => 'no-cache, must-revalidate'
        ];
        return $this->__sendResponse('User', $data, 200, 'User list retrieved successfully.');
    }

    public function editPhoto(Request $request, $id){
        $data['stickers'] = Sticker::all();

        $this->__view = 'subadmin/photo_feed_edit';
        $data['pMedia'] = ProjectMedia::getById($id,['tags_data']);

        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $data  , 200, 'User list retrieved successfully.');
    }

    public function updatePhoto (Request $request,$id){
        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__collection = false;

        $pm = ProjectMedia::where(['id' => $id])->first();

        $pmUpdate = [];
        if ($request->hasFile('image')) {
//            if(file_exists(public_path(config('constants.MEDIA_IMAGE_PATH')).$pm['path'])){
//                unlink(public_path(config('constants.MEDIA_IMAGE_PATH')).$pm['path'] );
//            }
            $imageName = $request['user_id'] . "-" . time() . '_' . rand() . '.jpg';
            $request->file('image')->move(public_path(config('constants.MEDIA_IMAGE_PATH')), $pm['path']);
            //$pmUpdate['path'] = $imageName;
            \Log::debug('image'.print_r($request->all(),1));
        }

        //<editor-fold desc="Updating DB Block">
        $pmUpdate['note'] = $request->note;
        $pmRes = ProjectMedia::where(['id' => $id])->update($pmUpdate);
        $res = ProjectMediaTag::updateMediaTag($id,$request->all());
        //</editor-fold>

        //<editor-fold desc="Updating Watermark Block">
        $pMedia = ProjectMedia::where(['id' => $id])->first()->toArray();
        $pMediaTag = ProjectMediaTag::with(['ref_tags'])->where(['target_id' => $id , 'target_type' => 'media'])->get();
        $tags = [];
        foreach ($pMediaTag AS $key => $item){
            $tags[]['id'] = $item['ref_tags']['id'];
            $tags[]['company_id'] = $item['ref_tags']['company_id'];
            $tags[]['ref_id'] = $item['ref_tags']['ref_id'];
            $tags[]['ref_type'] = $item['ref_tags']['ref_type'];
            $tags[]['name'] = $item['ref_tags']['name'];
            $tags[]['has_qty'] = $item['ref_tags']['has_qty'];
        }

        $p = Project::getById($pMedia['project_id']);
        $p = $p->toArray();

        $imgParam['latitude'] = $p['latitude'];
        $imgParam['longitude'] = $p['longitude'];
        $imgParam['inspection_date'] = $p['inspection_date'];
        $imgParam['user_id'] = $p['assigned_user_id'];
        $imgParam['category_id'] = $pMedia['category_id'];
        $imgParam['note'] = $pMedia['note'];
        $imgParam['image_path'] = $pMedia['path'];
        $imgParam['tags'] = ($pMediaTag->isNotEmpty()) ? array_column($pMediaTag->toArray(),'ref_tags') : [] ;
        $imgParam['mode'] = 'update';

        // public/uploads/media/1620146493626-1620147296-1523748270.jpg
        ProjectMedia::addImageText_2($imgParam);
        //</editor-fold>

        if($res['error']){
            return $this->__sendError($res['error'],[$res['error']],'400');
        }

        $project = Project::where(['id' => $pm['project_id'] ])->update(['is_updated' => 1]);

        return $this->__sendResponse('User', [], 200, 'Photo updated successfully.');
    }

    /** Get photo and its child entities details */
    public function details(Request $request,$id)
    {
        $this->__view = 'subadmin/photo_feed_details';
        $request['id'] = $id ;
        //<editor-fold desc="Validation">
        $param_rules['id'] = [
            'required',
            'int',
            Rule::exists('project_media', 'id')->whereNull('deleted_at')
        ];
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error)
            return $response;
        //</editor-fold>
        //$media['latest_photos'] = ProjectMedia::getLatestPhotos($request->all());
        $projectid = ProjectMedia::where('id',$id)->pluck('project_id')->toArray();
        $media = ProjectMedia::getById($id,['tags_data','category']);
        $media['project'] = Project::getById($projectid);
        $media['area'] =  Category::where('id',$media['category']['parent_id'])->first();
//        die('valdiation good: '.$id);
        
        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;
        
        return view('subadmin/photo_feed_details',compact('media','id'));
    }
}


