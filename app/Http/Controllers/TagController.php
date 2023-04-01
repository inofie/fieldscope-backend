<?php

namespace App\Http\Controllers;

use App\Exports\CategoryTagSampleExport;
use App\Exports\TagExport;
use App\Http\Middleware\LoginAuth;
use App\Libraries\JobScope;
use App\Libraries\Helper;
use App\Models\Category;
use App\Models\CrmModel;
use App\Models\EvProduct;
use App\Models\HoverField;
use App\Models\HoverFieldType;
use App\Models\Tag;
use App\Models\Uom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
                'store', 'index', 'show', 'edit', 'update', 'getSetting', 'profile', 'tagList',
                'catTagList', 'catTagDatatable', 'catTagExport', 'tagImportView' ]
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
        $request['keyword'] = isset($request['keyword']) ? $request['keyword'] : NULL;
        $list = Tag::getList($request->all());
        $this->__is_paginate = false;
        $this->__is_collection = true;
        return $this->__sendResponse('Tag', $list, 200, 'Tag list retrieved successfully.');
    }

    public function tagList(Request $request){

        $this->__view = 'subadmin/tags_mgmt';

        $tagModel = new Tag();


        $param['parent_id'] = 0;
        $param['paginate']  = TRUE;
        $param['company_id'] = $request['company_id'];
        $param['type'] = 2;
        $param['keyword'] = $request['keyword'];
        $list['tags'] = $tagModel->getCompanyTags($param);
        $list['uoms'] = Uom::all();

        $subCatparam['paginate']    = FALSE;
        $subCatparam['company_id']  = $request['company_id'];
        $subCatparam['type']        = 2;
        $list['photoViews']         = Category::getSubCategory_withParents($subCatparam);

        $crmModel = new CrmModel();
        $list['specTypes'] = $crmModel->specTypes;

        $list['hover_field_types'] = HoverFieldType::select('id','name')->get();
//        pd($list['hover_field_types']->toArray(),'$list[\'hover_field_types\']');

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function tagDatatable (Request $request){
        $params = $request->all();

        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];

//        $params['parent_id'] = 0;
        $params['paginate']  = TRUE;
        $params['company_id'] = $request['company_id'];
//        $params['user_group_id'] = 2;
        $params['type'] = 2;
        $params['keyword'] = $request['keyword'];

        if(!empty($params['reOrder'])){
            //Log::info('catTagDatatable: ',$params);
            $reOrderRes = Tag::reOrder($params['reOrder'],$params['company_id'],$params['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $dataTableRecord = Tag::getTagsDatatable($params);

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
                    'c1_name' => $record->c1_name,
                    'has_qty' => !empty($record->has_qty) ? 'Yes' : 'No',
                    'is_required' => !empty($record->is_required) ? 'Yes' : 'No',
                    'price' => !empty($record->price) ? '$'.$record->price: '$0',
                    'order_by' => !empty($record->order_by) ? $record->order_by: 0,
                ];
            }
        }
        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    public function store(Request $request)
    {
        //<editor-fold desc="Validation">
        $route = \Route::getCurrentRoute();
        if(Helper::uriSegment($route->uri,'tag')){
            $this->__view = 'subadmin/tag';
//            $param_rules['spec_type'] = 'required|string|max:50';
//            $param_rules['build_spec'] = 'required|string|max:50';
            $param_rules['hover_field_type_id'] = 'nullable|string|max:50';
            $param_rules['hover_field_id'] = 'nullable|string|max:50';
            $catType = 2;
        }else{
            $this->__view = 'subadmin/cat_tag';
            $catType = 1;
        }

        $this->__is_redirect = true;

        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['annotation'] = 'required|string|max:100';
        $param_rules['has_qty'] = 'required|int';
        $param_rules['ref_id'] = 'required|int';

        $param_rules['price']            = 'nullable|numeric';
        $param_rules['uom_id']           = 'nullable|numeric';
        $param_rules['material_cost']    = 'nullable|numeric';
        $param_rules['labor_cost']       = 'nullable|numeric';
        $param_rules['equipment_cost']   = 'nullable|numeric';
        $param_rules['supervision_cost'] = 'nullable|numeric';
        $param_rules['margin']           = 'nullable|numeric';

        $messages = [
            'ref_id.required' => 'Req. Photo field is required',
            'has_qty.required' => 'Quantity field is required',
            'hover_field_type_id.required' => 'Hover field type is required',
            'hover_field_id.required' => 'Hover field is required',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules, $messages);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        $maxTag = Tag::selectRaw('IFNULL(order_by,0) AS order_by')->join('category AS c','c.id','=','tag.ref_id' )
            ->where(['tag.company_id' => $request->company_id , 'tag.ref_type' => 'category','c.type' =>  $catType ])
            ->whereNull('tag.deleted_at')->max('tag.order_by');

//        p($maxTag,'$maxTag');

        $tag = new Tag();
        $tag['company_id']  =             $request['company_id'];
        $tag['ref_id']      =             $request['ref_id'];
        $tag['ref_type']    =             'category';
        $tag['name']        =             $request['name'];
        $tag['annotation']        =             $request['annotation'];
        $tag['has_qty']     =             $request['has_qty'];
        $tag['is_required'] =             !empty($request['is_required']) ? $request['is_required'] : 0;
        $tag['spec_type'] =               !empty($request['spec_type']) ? $request['spec_type'] : 0;
        $tag['build_spec'] =              !empty($request['build_spec']) ? $request['build_spec'] : 0;
        $tag['order_by'] =              !empty($maxTag) ? (int)$maxTag+1 : 1;
//        $tag['ev_primary_product_id'] =   !empty($request['ev_report_type']) ? $request['ev_report_type'] : 0;
//        $tag['ev_product_field_id'] =     !empty($request['ev_field']) ? $request['ev_field'] : 0;

        $tag['price']       =             !empty($request['price']) ? $request['price'] : null;
        $tag['uom_id'] =            $request['uom_id'] ?: null;
        $tag['material_cost'] =     $request['material_cost'] ?: null;
        $tag['labor_cost'] =        $request['labor_cost'] ?: null;
        $tag['equipment_cost'] =    $request['equipment_cost'] ?: null;
        $tag['supervision_cost'] =  $request['supervision_cost'] ?: null;
        $tag['margin'] =            $request['margin'] ?: null;
        $tag['hover_field_type_id'] =       !empty($request['hover_field_type_id']) ? $request['hover_field_type_id'] : 0;
        $tag['hover_field_id'] =            !empty($request['hover_field_id']) ? $request['hover_field_id'] : 0;

//        pd($tag,'$tag');

        if (!$tag->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editTagDetails(Request $request, $id)
    {
        $param['company_id'] = $request['company_id'];
        $param['id'] = $id;
        $list = Tag::where($param)->first();

        $this->__is_paginate = false;
        $this->__is_ajax = true;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('CompanyGroup', $list, 200,'Tag retrieved successfully.');
    }

    public function updateTag(Request $request, $id)
    {
        $route = \Route::getCurrentRoute();
        if (Helper::uriSegment($route->uri, 'tag')) {
            $this->__view = 'subadmin/tag?page=' . $request['page'];
//            $param_rules['spec_type'] = 'required|string|max:50';
//            $param_rules['build_spec'] = 'required|string|max:50';

            $param_rules['hover_field_type_id'] = 'nullable|string|max:50';
            $param_rules['hover_field_id'] = 'nullable|string|max:50';
        } else {
            $this->__view = 'subadmin/cat_tag?page=' . $request['page'];
        }

        $this->__is_redirect = true;

        $param_rules['company_id']  = 'required|int';
        $param_rules['name']        = 'required|string|max:100';
        $param_rules['annotation'] = 'required|string|max:100';
        $param_rules['has_qty']     = 'required|int';
        $param_rules['ref_id']      = 'required|int';
        $param_rules['is_required'] = 'nullable|in:false,true';
        $param_rules['price']       = 'nullable|numeric';

        $param_rules['uom_id'] = 'nullable|numeric';
        $param_rules['material_cost'] = 'nullable|numeric';
        $param_rules['labor_cost'] = 'nullable|numeric';
        $param_rules['equipment_cost'] = 'nullable|numeric';
        $param_rules['supervision_cost'] = 'nullable|numeric';
        $param_rules['margin'] = 'nullable|numeric';

        $messages = [
            'ref_id.required' => 'Req. Photo field is required',
            'has_qty.required' => 'Quantity field is required',
            'hover_field_type_id.required' => 'Hover field type is required',
            'hover_field_id.required' => 'Hover field is required',
        ];

        $response = $this->__validateRequestParams($request->all(), $param_rules,$messages);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $tag = new Tag();
        $tag = $tag::find($id);
        $tag['company_id']  =   $request['company_id'];
        $tag['ref_id'] =   $request['ref_id'];
        $tag['name']        =   $request['name'];
        $tag['annotation']        =   $request['annotation'];
        $tag['has_qty']     =   $request['has_qty'];
        $tag['spec_type'] =   !empty($request['spec_type']) ? $request['spec_type'] : 0;
        $tag['build_spec'] =   !empty($request['build_spec']) ? $request['build_spec'] : 0;

//        $tag['ev_primary_product_id'] =   !empty($request['ev_report_type']) ? $request['ev_report_type'] : 0;
//        $tag['ev_product_field_id'] =   !empty($request['ev_field']) ? $request['ev_field'] : 0;

        $tag['price'] = !empty($request['price']) ? $request['price'] : null;
        $tag['uom_id'] =            $request['uom_id'] ?: null;
        $tag['material_cost'] =     $request['material_cost'] ?: null;
        $tag['labor_cost'] =        $request['labor_cost'] ?: null;
        $tag['equipment_cost'] =    $request['equipment_cost'] ?: null;
        $tag['supervision_cost'] =  $request['supervision_cost'] ?: null;
        $tag['margin'] =            $request['margin'] ?: null;

        $tag['hover_field_type_id'] =   !empty($request['hover_field_type_id']) ? $request['hover_field_type_id'] : 0;
        $tag['hover_field_id'] =     !empty($request['hover_field_id']) ? $request['hover_field_id'] : 0;

        $tag['is_required'] = (!empty($request['is_required']) AND $request['is_required'] == 'true') ? 1 : 0;

        if (!$tag->save()) {
            return $this->__sendError('Query Error', 'Unable to update record.');
        }

        $this->__setFlash('success', 'Updated Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag updated successfully.');
    }

    public function deleteTag(Request $request, $id)
    {
        $request['id'] = $id;
        $param_rules['id'] = 'required|int|';

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == true) {
            $error = \Session::get('error');
            $this->__setFlash('danger', 'Not Deleted Successfully', $error['data']);
            return $response;
        }

        $tag = Tag::where('id',$id)->delete();
        if(!$tag){
            $error['data'][0] = "Delete Failed ";
            $this->__setFlash('danger','Not Delete Successfully' , $error['data']);
            return $this->__sendError('Query Error','Unable to Delete record.' );
        }

        $this->__setFlash('success', 'Deleted Successfully');
        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag deleted successfully.');

    }

    public function catTagList(Request $request){
        $this->__view = 'subadmin/req_tags_mgmt';

        $catParam['parent_id']   = 0;
        $catParam['paginate']    = FALSE;
        $catParam['company_id']  = $request['company_id'];
        $catParam['type']        = 1;
        $list['req_photo']       = Category::getCategoryList($catParam);
        $list['uoms'] = Uom::all();

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function catTagDatatable (Request $request){
        $params = $request->all();

        $params['column_index'] = $params['order'][0]['column'];
        $params['sort'] = $params['order'][0]['dir'];

        $params['parent_id'] = 0;
        $params['paginate']  = TRUE;
        $params['company_id'] = $request['company_id'];
        $params['user_group_id'] = 2;
        $params['type'] = 1;
        $params['keyword'] = $request['keyword'];


        if(!empty($params['reOrder'])){
            //Log::info('catTagDatatable: ',$params);
            $reOrderRes = Tag::reOrder($params['reOrder'],$params['company_id'],$params['start']);
            if(!empty($reOrderRes['error'])){
                $this->__is_ajax = true;
                return $this->__sendError($reOrderRes['error'],[],'400');
            }
        }

        $dataTableRecord = Tag::getReqTagsDatatable($params);

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
                    'c1_name' => $record->c1_name,
                    'has_qty' => !empty($record->has_qty) ? 'Yes' : 'No',
                    'is_required' => !empty($record->is_required) ? 'Yes' : 'No',
                    'price' => !empty($record->price) ? '$'.$record->price: '$0',
                    'order_by' => !empty($record->order_by) ? $record->order_by: 0,
                ];
            }
        }
        $records["draw"] = (int)$request->input('draw');
        $records["recordsTotal"] = $dataTableRecord['total_record'];
        $records["recordsFiltered"] = $dataTableRecord['total_record'];

        return response()->json($records);
    }

    //<editor-fold desc="Req. Tag Import Methods">
    public function catTagExport (Request $request){

        $catParam['parent_id'] = 0;
        $catParam['paginate']    = FALSE;
        $catParam['company_id']  = $request['company_id'];
        $catParam['type']        = 1;
        $reqPhoto = Category::getCategoryList($catParam);

//        $tagExport = ;
        return (new CategoryTagSampleExport($reqPhoto))->download('test.xlsx');

        $hoverFieldTypes = HoverField::selectRaw('hover_fields.id,hover_fields.name')->withFieldType()->get()->toArray();

        $uoms = Uom::all('id','title')->toArray();
        dd($reqPhoto->toArray());

        return  \Excel::download(function($excel) use($reqPhoto,$uoms,$hoverFieldTypes) {

            $excel->sheet('data', function($sheet) use($reqPhoto,$uoms,$hoverFieldTypes) {

                $sheet->cell('A1', function($cell) {$cell->setValue('category_id');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('category_name');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('name');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('has_qty');   });
                $sheet->cell('E1', function($cell) {$cell->setValue('is_required');   });
                $sheet->cell('F1', function($cell) {$cell->setValue('price');   });

                $sheet->cell('G1', function($cell) {$cell->setValue('uom_id');   });
                $sheet->cell('H1', function($cell) {$cell->setValue('uom');   });
                $sheet->cell('I1', function($cell) {$cell->setValue('material_cost');   });
                $sheet->cell('J1', function($cell) {$cell->setValue('labor_cost');   });
                $sheet->cell('K1', function($cell) {$cell->setValue('equipment_cost');   });
                $sheet->cell('L1', function($cell) {$cell->setValue('supervision_cost');   });
                $sheet->cell('M1', function($cell) {$cell->setValue('margin');   });
                $sheet->cell('N1', function($cell) {$cell->setValue('hover_field_type_id');   });
                $sheet->cell('O1', function($cell) {$cell->setValue('hover_field_type');   });
                $sheet->cell('P1', function($cell) {$cell->setValue('hover_field_id');   });
                $sheet->cell('Q1', function($cell) {$cell->setValue('hover_field');   });
                $sheet->cell('R1', function($cell) {$cell->setValue('annotation');   });

                if (!empty($reqPhoto)) {
                    foreach ($reqPhoto as $key => $value) {
                        $i= $key+2;
                        $sheet->cell('A'.$i, $value['id']);
                        $sheet->cell('B'.$i, $value['name']);
                    }
                }

                if (!empty($uoms)) {
                    $counter = 2;
                    foreach ($uoms as $uKey => $uom) {
                        /** UOM */
                        $sheet->cell('G'.$counter, $uom['id']);
                        $sheet->cell('H'.$counter, $uom['title']);
                        $counter++;
                    }
                }

                if (!empty($hoverFieldTypes)) {
                    $counter = 2;
                    foreach ($hoverFieldTypes as $hover => $hoverFieldType) {
                        /** Hover */
                        $sheet->cell('N'.$counter, $hoverFieldType['hover_field_type_id']);
                        $sheet->cell('O'.$counter, $hoverFieldType['hover_field_type_name']);
                        $sheet->cell('P'.$counter, $hoverFieldType['id']);
                        $sheet->cell('Q'.$counter, $hoverFieldType['name']);
                        $counter++;
                    }
                }
//                Library additional params
//                ->fromArray($source, $nullValue, $startCell, $strictNullComparison, $headingGeneration)

            });

            $excel->sheet('example', function($sheet) {
                $sheet->cell('A1', function($cell) {$cell->setValue('category_id');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('category_name');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('name');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('has_qty');   });
                $sheet->cell('E1', function($cell) {$cell->setValue('is_required');   });
                $sheet->cell('F1', function($cell) {$cell->setValue('price');   });

                $sheet->cell('A2', function($cell) {$cell->setValue('1');                       });
                $sheet->cell('B2', function($cell) {$cell->setValue('sample category name 1');   });
                $sheet->cell('C2', function($cell) {$cell->setValue('Tag name 1');              });
                $sheet->cell('D2', function($cell) {$cell->setValue('yes');                    });
                $sheet->cell('E2', function($cell) {$cell->setValue('yes');                    });
                $sheet->cell('F2', function($cell) {$cell->setValue('2');                       });

                $sheet->cell('A3', function($cell) {$cell->setValue('1');     });
                $sheet->cell('B3', function($cell) {$cell->setValue('sample category name 1');   });
                $sheet->cell('C3', function($cell) {$cell->setValue('Tag name 2');            });
                $sheet->cell('D3', function($cell) {$cell->setValue('no');            });
                $sheet->cell('E3', function($cell) {$cell->setValue('no');            });
                $sheet->cell('F3', function($cell) {$cell->setValue('7');                   });

                $sheet->cell('A4', function($cell) {$cell->setValue('2');     });
                $sheet->cell('B4', function($cell) {$cell->setValue('sample category name 2');   });
                $sheet->cell('C4', function($cell) {$cell->setValue('Tag name 3');            });
                $sheet->cell('D4', function($cell) {$cell->setValue('yes');            });
                $sheet->cell('E4', function($cell) {$cell->setValue('no');            });
                $sheet->cell('F4', function($cell) {$cell->setValue('17');                   });


//                ->fromArray($source, $nullValue, $startCell, $strictNullComparison, $headingGeneration)

            });

        },'Req_Catgory.xlsx')
//            ->export('xlsx')
            ;
    }

    public function catTagImportView (Request $request){
        $this->__view = 'subadmin/req_tags_import';

        $catParam['parent_id'] = 0;
        $catParam['paginate']    = FALSE;
        $catParam['company_id']  = $request['company_id'];
        $catParam['type']        = 1;
        $list['req_photo']         = Category::getCategoryList($catParam);

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'User list retrieved successfully.');
    }

    public function catTagImport (Request $request){

        $this->__view = 'subadmin/cat_tag/import';
        $this->__is_redirect = true;

        $param_rules['import_file'] = 'required|mimes:csv,txt,xlsx,xls';

        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $tags = \Excel::selectSheetsByIndex(0)->load($request['import_file'])->get();

        if (empty($tags->toArray())) {
            $this->__setFlash('danger', 'Provided file is empty');
            $this->__is_paginate = false;
            $this->__is_collection = false;
            return $this->__sendResponse('Tag', [], 200, 'Failed');
        }
        $request['type']= 1;
        $insertRes = Tag::insertFromImportFile($tags,$request->all());

        if (!$insertRes || $insertRes['error']) {
            $this->__setFlash('danger', 'Failed to import tags',[$insertRes['error']]);
            $this->__is_paginate = false;
            $this->__is_collection = false;
            return $this->__sendResponse('Tag', [], 200, 'Added successfully.');
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200, 'Your lead has been added successfully.');
    }
    //</editor-fold>

    //<editor-fold desc="Photo Tags Import Methods">
    public function tagExport (Request $request){

        $subCatparam['paginate']    = FALSE;
        $subCatparam['company_id']  = $request['company_id'];
        $subCatparam['type']        = 2;
        $photoViews         = Category::getSubCategory_withParents($subCatparam);

        $hoverFieldTypes = HoverField::selectRaw('hover_fields.id,hover_fields.name')->withFieldType()->get()->toArray();

        $uoms = Uom::all('id','title')->toArray();

        $crm = new JobScope();
        $crm->getSpecs();

        return  \Excel::create('Photo_View', function($excel) use($photoViews,$crm,$uoms,$hoverFieldTypes) {

            $excel->sheet('data', function($sheet) use($photoViews,$crm,$uoms,$hoverFieldTypes) {

                $sheet->cell('A1', function($cell) {$cell->setValue('category_id');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('category_name');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('name');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('has_qty');   });
                $sheet->cell('E1', function($cell) {$cell->setValue('is_required');   });
                $sheet->cell('F1', function($cell) {$cell->setValue('price');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('spec_type');   });
                $sheet->cell('H1', function($cell) {$cell->setValue('build_spec');   });
                $sheet->cell('I1', function($cell) {$cell->setValue('uom_id');   });
                $sheet->cell('J1', function($cell) {$cell->setValue('uom');   });
                $sheet->cell('K1', function($cell) {$cell->setValue('material_cost');   });
                $sheet->cell('L1', function($cell) {$cell->setValue('labor_cost');   });
                $sheet->cell('M1', function($cell) {$cell->setValue('equipment_cost');   });
                $sheet->cell('N1', function($cell) {$cell->setValue('supervision_cost');   });
                $sheet->cell('O1', function($cell) {$cell->setValue('margin');   });
                $sheet->cell('P1', function($cell) {$cell->setValue('hover_field_type_id');   });
                $sheet->cell('Q1', function($cell) {$cell->setValue('hover_field_type');   });
                $sheet->cell('R1', function($cell) {$cell->setValue('hover_field_id');   });
                $sheet->cell('S1', function($cell) {$cell->setValue('hover_field');   });
                $sheet->cell('T1', function($cell) {$cell->setValue('annotation');   });

                if (!empty($photoViews)) {
                    foreach ($photoViews as $key => $value) {
                        $i= $key+2;
                        $sheet->cell('A'.$i, $value['category2_id']);
                        $sheet->cell('B'.$i, $value['category2_name']);
                    }
                }

                if (!empty($crm->response['data'])) {
                    $counter = 2;
                    foreach ($crm->response['data'] as $specKey => $specValue) {
                        /** BuildSpec*/
                        foreach($specValue AS $bKey => $bValue){
                            $sheet->cell('G'.$counter, $specKey);
                            $sheet->cell('H'.$counter, $bValue);
                            /*Helper::p($specKey,'$specKey');
                            Helper::p($specValue,'$specValue');*/
                            $counter++;
                        }
                    }
                }

                if (!empty($uoms)) {
                    $counter = 2;
                    foreach ($uoms as $uKey => $uom) {
                        /** UOM */
                        $sheet->cell('I'.$counter, $uom['id']);
                        $sheet->cell('J'.$counter, $uom['title']);
                        $counter++;
                    }
                }

                if (!empty($hoverFieldTypes)) {
                    $counter = 2;
                    foreach ($hoverFieldTypes as $hover => $hoverFieldType) {
                        /** Hover */
                        $sheet->cell('P'.$counter, $hoverFieldType['hover_field_type_id']);
                        $sheet->cell('Q'.$counter, $hoverFieldType['hover_field_type_name']);
                        $sheet->cell('R'.$counter, $hoverFieldType['id']);
                        $sheet->cell('S'.$counter, $hoverFieldType['name']);
                        $counter++;
                    }
                }
//                Library additional params
//                -fromArray($source, $nullValue, $startCell, $strictNullComparison, $headingGeneration)
            });
            $excel->sheet('example', function($sheet) {
                $sheet->cell('A1', function($cell) {$cell->setValue('category_id');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('category_name');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('name');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('has_qty');   });
                $sheet->cell('E1', function($cell) {$cell->setValue('is_required');   });
                $sheet->cell('F1', function($cell) {$cell->setValue('price');   });

                $sheet->cell('A2', function($cell) {$cell->setValue('1');                       });
                $sheet->cell('B2', function($cell) {$cell->setValue('sample category name 1');   });
                $sheet->cell('C2', function($cell) {$cell->setValue('Tag name 1');              });
                $sheet->cell('D2', function($cell) {$cell->setValue('yes');                    });
                $sheet->cell('E2', function($cell) {$cell->setValue('yes');                    });
                $sheet->cell('F2', function($cell) {$cell->setValue('2');                       });

                $sheet->cell('A3', function($cell) {$cell->setValue('1');     });
                $sheet->cell('B3', function($cell) {$cell->setValue('sample category name 1');   });
                $sheet->cell('C3', function($cell) {$cell->setValue('Tag name 2');            });
                $sheet->cell('D3', function($cell) {$cell->setValue('no');            });
                $sheet->cell('E3', function($cell) {$cell->setValue('no');            });
                $sheet->cell('F3', function($cell) {$cell->setValue('7');                   });

                $sheet->cell('A4', function($cell) {$cell->setValue('2');     });
                $sheet->cell('B4', function($cell) {$cell->setValue('sample category name 2');   });
                $sheet->cell('C4', function($cell) {$cell->setValue('Tag name 3');            });
                $sheet->cell('D4', function($cell) {$cell->setValue('yes');            });
                $sheet->cell('E4', function($cell) {$cell->setValue('no');            });
                $sheet->cell('F4', function($cell) {$cell->setValue('17');                   });
            });
        })->export('xlsx');
    }

    public function tagImportView (Request $request){
        $this->__view = 'subadmin/tags_import';

        $subCatparam['paginate']    = FALSE;
        $subCatparam['company_id']  = $request['company_id'];
        $subCatparam['type']        = 2;
        $list['photoViews']         = Category::getSubCategory_withParents($subCatparam);

        $this->__is_ajax = false;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('User', $list, 200, 'Added successfully.');
    }

    public function TagImport (Request $request){

        $this->__view = 'subadmin/tag/import';
        $this->__is_redirect = true;

        $param_rules['import_file'] = 'required|mimes:csv,txt,xlsx,xls';

        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $tags = \Excel::selectSheetsByIndex(0)->load($request['import_file'])->get();

        $request['type']= 2;
        $insertRes = Tag::insertFromImportFile($tags,$request->all());

        if (!$insertRes || $insertRes['error']) {
            $this->__setFlash('danger', !empty($insertRes['error']) ? $insertRes['error'] : 'Failed to import tags');
            $this->__is_paginate = false;
            $this->__is_collection = false;
            return $this->__sendResponse('Tag', [], 200, 'Added successfully.');
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200, 'Added successfully.');
    }
    //</editor-fold>
}

