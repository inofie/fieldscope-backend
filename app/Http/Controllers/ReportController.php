<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LoginAuth;
use App\Libraries\Sign\HelloSign;
use App\Libraries\Sign\SignNow;
use App\Models\Category;
use App\Models\CompanyReport;
use App\Models\Project;
use App\Models\Report;
use App\Models\ReportTemplate;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{

    private $templatesPath = NULL,$report,$companyDetails,$userDetails,$projectDetails,$companyTemplates,$totalPages;
    private $mpdf = NULL;

    private $optionsRequest = '{"Introduction":[{"id":2,"title":"test","identifier":"introduction","selected":"false"},{"id":6,"title":"test 2","identifier":"introduction","selected":"true"}],"Credit_Disclaimer":true,"Owner_Authorization":true,"Terms_Conditions":true,"Documents":[{"id":3,"title":"test","identifier":"documents","selected":"true"}],"categories":[{"id":7,"name":"Additional Photos","selected":true,"Estimations":true},{"id":8,"name":"Inspection Area","selected":true,"Estimations":true},{"id":12,"name":"Roof Inspection","selected":true,"Estimations":true},{"id":14,"name":"Front Elevation","selected":true,"Estimations":true},{"id":54,"name":"New Area","selected":true,"Estimations":true}],"breakdown":{"Units_Of_Measure":true,"Material_Cost":true,"Labor_Cost":true,"Equipment_Cost":true,"Supervision_Cost":true,"Margin_%":true,"Sales_Tax":true,"Line_Item_Total":true}}';
    private $ownerAuthorization = "";
    function __construct()
    {
        // ini_set('max_execution_time','200');
        parent::__construct();
        $this->middleware(LoginAuth::class, ['only' => [
                'store', 'index', 'show', 'edit', 'update','getReportOptions' ,'createReport'
            ]
        ]);
        $this->templatesPath = config("constants.REPORT_TEMPLATE_FILE_PATH");
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

        $this->__is_paginate = true;
        $this->__is_collection = true;
        return $this->__sendResponse('Tag', $list, 200, 'Tag list retrieved successfully.');
    }

    public function getReportOptions(Request $request, $projectId)
    {

        //<editor-fold desc="Validation">
        $param_rules['project_id'] = [
            'required',
            'int',
            Rule::exists('project', 'id')
                ->where('company_id',$request['company_id'])
                ->whereNull('deleted_at')
        ];
        $request['project_id'] = $projectId;
        $response = $this->__validateRequestParams($request->all(),$param_rules);

        if($this->__is_error == true)
            return $response;

        //</editor-fold>

        $report = Report::where(['project_id' => $projectId])->first(['id','options']);
        $lastSelectedOptions = [];

        if($report){
            $lastSelectedOptions = collect(json_decode($report->options));
        }

        $options = [
            'Introduction' => false,
            'Credit_Disclaimer' => false,
            'Owner_Authorization' => $lastSelectedOptions['Owner_Authorization'] ?: false,
            'Terms_Conditions' => $lastSelectedOptions['Terms_Conditions'] ?: false,
            'Documents' => false,
        ];

        $companyReportM = new CompanyReport();
        $companyReport = $companyReportM->where(['company_id' => $request['company_id']])->first(['is_disclaimer','json_data']);

        $ownAuthorization = json_decode($companyReport->json_data,true);

        $options['owner_authorization']['section_title'] = "Optional Upgrades";
        $options['owner_authorization']['item_title'] = "Optional Upgrades";

        $options['owner_authorization']['section_items'] = collect($ownAuthorization['section_item']['item'])->map(function ($el,$index) use($lastSelectedOptions){
            $matchedOption = collect($lastSelectedOptions['owner_authorization']->section_items)->where('id',$index+1)->first();
            return ['id' =>$index+1 , 'name' => $el,
                'selected' => $matchedOption->selected ?: false
            ];
        });

        $options['owner_authorization']['item_options'] = collect($ownAuthorization['item_option'])->map(function ($el,$index) use($lastSelectedOptions) {
            $matchedOption = collect($lastSelectedOptions['owner_authorization']->item_options)->where('id',$index+1)->first();

            return ['id' =>$index+1 ,'name' => $el,
                'value' => $matchedOption->value ?: '',
            ];
        });

        $options['owner_authorization']['special_instruction'] = $lastSelectedOptions['owner_authorization']->special_instruction ?:null;

        if(!$companyReport->is_disclaimer){
            unset($options['Credit_Disclaimer']);
        }

        $category = new Category();
        $categories = $category->getCompanyGroupCategories($request->all());

        $options['categories'] = $categories->map(function ($item,$key) use($lastSelectedOptions) {

            $matchedCat = collect($lastSelectedOptions['categories'])->where('id',$item->id)->first();

            $result = [
                'id' => $item->id,
                'name' => title_case($item->name),
                'selected' => $matchedCat->selected ?: FALSE,
            ];

            return $result;
        })->toArray();

        $options['Estimates'] = $categories->filter(function ($item, $key) {
            if (!in_array($item->type, [3])) {
                $result = [
                    'id' => $item->id,
                    'name' => title_case($item->name),
                    'selected' => FALSE,
                ];
                return $result;
            }
        })->map(function ($item, $key) use($lastSelectedOptions) {

            $matchedEst = collect($lastSelectedOptions['Estimates'])->where('id',$item->id)->first();
            $result = [
                'id' => $item->id,
                'name' => title_case($item->name." Estimate"),
                'selected' => $matchedEst->selected ?: FALSE ,
            ];
            return $result;

        })->values();

        $options['breakdown'] = [
            'Units_Of_Measure' =>   $lastSelectedOptions['breakdown']->Units_Of_Measure ?: FALSE,
            'Material_Cost' =>      $lastSelectedOptions['breakdown']->Material_Cost ?: FALSE,
            'Labor_Cost' =>         $lastSelectedOptions['breakdown']->Labor_Cost ?: FALSE,
            'Equipment_Cost' =>     $lastSelectedOptions['breakdown']->Equipment_Cost ?: FALSE,
            'Supervision_Cost' =>   $lastSelectedOptions['breakdown']->Supervision_Cost ?: FALSE,
            'Margin_%' =>           $lastSelectedOptions['breakdown']->Margin_ ?: FALSE,
            'Sales_Tax' =>          $lastSelectedOptions['breakdown']->Sales_Tax ?: FALSE,
            'Line_Item_Total' =>    $lastSelectedOptions['breakdown']->Line_Item_Total ?: FALSE,
        ];


        $templates = ReportTemplate::selectRaw("id,title,identifier,'false' AS selected")->where(['company_id' => $request['company_id']])->whereNull('deleted_at')->get();


        $templates = $templates->map(function ($template, $key) use($lastSelectedOptions) {
            $template->selected = !empty($lastSelectedOptions) ? $lastSelectedOptions->only(['Introduction','Documents'])->flatten()->contains('id',$template->id) : FALSE;
            return $template;
        })->groupBy('identifier')->toArray();

        $options['Introduction'] = $templates['introduction'];
        $options['Documents'] = $templates['documents'];

        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Tag', $options, 200, 'Tag list retrieved successfully.');
    }

    public function createReport(Request $request, $projectId)
    {
        if(isset($request->request_options['owner_authorization']['section_items']) && isset($request->request_options['owner_authorization']['item_options'])) {
            $items = [];
            $qty = [];
            $price = [];
            $total = [];
            $item_options = [];
            foreach($request->request_options['owner_authorization']['section_items'] as $selectd_items) {
                array_push($items,$selectd_items['name']);
                $getqty = (string)number_format($selectd_items['qty']);
                $getprice = (string)number_format($selectd_items['price'], 2, '.', '');
                $gettotal = (string)number_format($selectd_items['total'], 2, '.', '');
                array_push($qty,$getqty);
                array_push($price,$getprice);
                array_push($total,$gettotal);
            }
            foreach($request->request_options['owner_authorization']['item_options'] as $item_option) {
                array_push($item_options,$item_option['name']);
            }

            $new_data= (object)[];
            $new_data->section_item = (object)[];
            $new_data->section_item->item = $items;
            $new_data->section_item->qty = $qty;
            $new_data->section_item->price = $price;
            $new_data->section_item->total = $total;
            $new_data->item_option = $item_options;
            $new_data = json_encode($new_data);
            $crdata = CompanyReport::where(['company_id' => $request['company_id']])->first();
            $crdata->json_data = $new_data;
            $crdata->save();
        }

        $this->report = Report::firstOrNew(['project_id' => $projectId]);

        if ($this->report->exists && empty($request->request_options)) {

            $this->__collection = false;
            $this->__is_paginate = false;
            return $this->__sendResponse('Report',['url' => url($this->report['path'])],200,'Report Fetched Successfully');
        }else if(empty($request->request_options)) {
            return $this->__sendError("Report Not Found",['message'=> "You haven't create any report for the project"],400);
        }

        if($request->test){
            /** Test Mode: Autofill 'optionsRequest' AND $user object */
            $request['user-token'] = "670b4fa5948639577b80812b6d46b953";
            $this->optionsRequest = json_decode($this->optionsRequest, true);
            // $this->optionsRequest = $options;
            $user = User::where(['token' => $request->header('user-token')])->first();
        } else {
            $user = User::where(['id' => $request['user_id']])->first();
            $this->optionsRequest = $request['request_options'];
            $this->ownerAuthorization = $request['request_options']['owner_authorization'];
        }

        if ($this->report->exists) {
            /** Already Exist */
            $request['user_id'] = $this->report->user_id;
            $this->report->options = json_encode($this->optionsRequest);

            if(!$request->update_report){
                /** Set to Null If only we're not updating the report from sign process */
                $this->report->inspector_sign = NULL;
                $this->report->inspector_sign_at = NULL;
                $this->report->customer_sign = NULL;
                $this->report->customer_sign_at = NULL;
            }

        }else{
            /** IF NEW */
            $this->report->token = "report-" . uniqid() . "-" . time();
            $this->report->user_id = $request['user_id'];
            $this->report->options = json_encode($this->optionsRequest);
        }

        ini_set('memory_limit', '512M');

        $this->userDetails = $user;

        if (count((array)$user) < 1) {
            $this->__is_ajax = true;
            return $this->__sendError('This user token is invalid.', [['auth' => 'This user token is invalid.']], 200);
        }

        $request['user_id']             = $user['id'];
        $request['company_id']          = $user['company_id'];
        $request['company_group_id']    = $user['company_group_id'];
        $request['project_id']          = $projectId;
        $request->update_report         = $request->update_report;

        if ($request['test'] != true) {
            //<editor-fold desc="Basic Validation">
            $params = $request->all();
            $params['owner_authorization'] = $this->ownerAuthorization;

            $param_rules['request_options'] = 'required';
            $param_rules['user_id'] = 'required|int';
            $param_rules['company_id'] = 'required|int';
            $param_rules['company_group_id'] = 'required|int';
            $param_rules['project_id'] = [
                'required',
                'int',
                Rule::exists('project', 'id')->whereNull('deleted_at'),
            ];
            $param_rules['owner_authorization'] = 'nullable|array|min:4';

            $this->__is_ajax = true;
            $response = $this->__validateRequestParams($params, $param_rules);
            if ($this->__is_error == true)
                return $response;
            //</editor-fold>
        }

        //<editor-fold desc="Setting $this->companyTemplates">
        $identifiers = []; $selectedIds = [];
        $selectedIntro = collect($this->optionsRequest['Introduction'])->where('selected','true');
        $selectedDocs = collect($this->optionsRequest['Documents'])->where('selected','true');

        if(!empty($selectedIntro)){
            $selectedIntro = collect($selectedIntro)->pluck('id')->toArray();
        }

        if(!empty($selectedDocs)){
            $selectedDocs = collect($selectedDocs)->pluck('id')->toArray();
        }

        if(!empty($this->optionsRequest['Terms_Conditions']))
            $identifiers[] = "terms_conditions";

        $selectedIds = array_merge($selectedIntro,$selectedDocs);
        $params = ['company_id' => $request['company_id'] , 'ids' => $selectedIds , 'identifiers'=> $identifiers];
        $reportTemplates = new ReportTemplate();
        if (!empty($params['ids']) and !empty($params['identifiers'])) {
            $this->companyTemplates = $reportTemplates->getSelectedTemplates($params);
        }

        //</editor-fold>

        //<editor-fold desc="Setting $this->companyDetails">
        $this->companyDetails = CompanyReport::where(['company_id' => $request['company_id']])->first();
        $this->companyDetails->logo_path = url("uploads/report_templates/".$this->companyDetails->logo_path);
        $this->companyDetails->report_cover_image = url("uploads/report_templates/".$this->companyDetails->report_cover_image);
        $this->companyDetails->json_data = json_decode($this->companyDetails->json_data,true);

        if(empty($this->optionsRequest['Owner_Authorization'])){
            $this->companyDetails->json_data = NULL;
        }

        //</editor-fold>

        //<editor-fold desc="Where clause mapping">
        $whereClauses = ['whereCategory' => [], /*'whereSurvey' => [],*/ 'whereEstimates' => []];

        /**Just lowering cases*/
        $this->optionsRequest['breakdown'] = collect($this->optionsRequest['breakdown'])->mapWithKeys(function($item,$key){
            return [strtolower($key) => $item];
        });

        foreach ($this->optionsRequest['categories'] AS $key => $item) {
            if ($item['selected']) {
                $whereClauses['whereCategory'][] = $item['id'];
            }

//            if ($item['survey']) {
//                $whereClauses['whereSurvey'][] = $item['id'];
//            }

//            Commented on Jan-2023
//            if ($item['Estimates']) {
//                $whereClauses['whereEstimates'][$item['id']] = $this->optionsRequest['breakdown'];
//            }
        }


        foreach ($this->optionsRequest['Estimates'] AS $key => $item) {
            if ($item['selected']) {
                $whereClauses['whereEstimates'][$item['id']] = $this->optionsRequest['breakdown'] ;
            }
        }
        //</editor-fold>

       return $this->generateWebReport($request->all(),$whereClauses);
    }

    public function generateWebReport($request, $whereClauses)
    {


        /** All cats incase of need to show unselected categories*/
//        $allCatsParam = ['company_id' => $request['company_id'], 'company_group_id' => $request['company_group_id']];
//        $allCats = CompanyGroupCategory::getCategories($allCatsParam, TRUE);

        $request['category_id'] = $whereClauses['whereCategory'];

        $titles = [
            'additional_photos' => 'Additional Photos',
            'required_category' => 'Included Photos',
            'damaged_category' => 'Inspection Areas',
        ];

        $categories = User::getUserCategories($request);

        $project = Project::getCompleteProject($categories, $request['project_id']);

        $this->projectDetails = array_except($project->toArray(), ['last_crm_sync_at','project_media','categories','get_single_media','complete_address','assigned_user','company']);

        $this->projectDetails['latitude'] = round($this->projectDetails['latitude'], 2);
        $this->projectDetails['longitude'] = round($this->projectDetails['longitude'], 2);
        $this->projectDetails['inspection_date'] = date("F jS Y",strtotime($this->projectDetails['inspection_date']));

        $project = $project->toArray();

        $this->mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'default_font_color' => 'white',
            'default_font' => 'axiforma',
            'margin' => 0,
            'defaultPageNumStyle' => '1'
        ]);

        $this->mpdf->useActiveForms = true;

//        $this->mpdf->formUseZapD = true;
//        $this->mpdf->form_border_color = '0.6 0.6 0.72';
//        $this->mpdf->form_button_border_width = '2';
//        $this->mpdf->form_button_border_style = 'S';
//        $this->mpdf->form_radio_color = '#619eff'; 	// radio and checkbox
//        $this->mpdf->form_radio_background_color = '#242424';

        $this->mpdf->SetTitle($project['name']);

        //<editor-fold desc="Adding Cover Page">
        $this->mpdf->AddPage(
            '', // L - landscape, P - portrait
            'odd', // E-even|O-odd|even|odd|next-odd|next-even
            '', '', '',
            0, // margin_left
            0, // margin right
            0, // margin top
            0, // margin bottom
            0, // margin header
            0 // margin footer

        );

        $cover = view('reports/v2/cover_page',['companyDetails' => $this->companyDetails,
            'userDetails' => $this->userDetails, 'projectDetails' => $this->projectDetails ]);
        $this->mpdf->WriteHTML($cover);
//        return $this->output();
        $this->ownerAuthorization();
        // $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails ])->render());
        // $this->mpdf->AddPage(
        //     '', // L - landscape, P - portrait
        //     '', // E-even|O-odd|even|odd|next-odd|next-even
        //     '', '', '',
        //     15, // margin_left
        //     15, // margin right
        //     40, // margin top
        //     60, // margin bottom
        //     0, // margin header
        //     0);
        // $this->mpdf->SetHTMLFooter(view('reports/v2/footer', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails])->render());

        // $this->mpdf->WriteHTML(
        //     view("reports/v2/owner_authorization",
        //         ['companyDetails' => $this->companyDetails ]
        //     )->render()
        // );
        //</editor-fold>

        $this->companyIntroduction();

        //<editor-fold desc="Data population">
        if(true){
            foreach ($project['categories'] AS $typeKey => $typeItem) {

            if (count((array)$project['categories'][$typeKey]) > 0) {

                if ($typeKey == 'required_category') {
                    $selectedCatsIds = array_column($project['categories'][$typeKey], 'id');

                    $this->mpdf->AddPage(
                        '', // L - landscape, P - portrait
                        '', // E-even|O-odd|even|odd|next-odd|next-even
                        '', '', '',
                        15, // margin_left
                        15, // margin right
                        40, // margin top
                        60, // margin bottom
                        0, // margin header
                        0);
                    $this->mpdf->SetHTMLFooter(view('reports/v2/footer', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails])->render());
                    $this->mpdf->WriteHTML($this->fourImagesTemplate($project, $project['categories'][$typeKey]));

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
                                            $catEstimates[$mCatKey]['inspectionAreaId'] = $mCatItem['id'];
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
                        $this->estimatesTemplate($catEstimates);
                    }
                    //</editor-fold>

                    $this->componentTemplate($project['categories'][$typeKey]);
                }
                else if ($typeKey == 'damaged_category') {
                    /** Inspection Areas > Photo Views*/

                    $selectedCatsIds = array_column($project['categories'][$typeKey], 'id');

    //                    $this->mpdf->WriteHTML($this->areaTemplate($allCats[$typeKey], $selectedCatsIds, $titles[$typeKey], $mapPath));
                    $this->mpdf->AddPage(
                        '', // L - landscape, P - portrait
                        '', // E-even|O-odd|even|odd|next-odd|next-even
                        '', '', '',
                        15, // margin_left
                        15, // margin right
                        40, // margin top
                        60, // margin bottom
                        0, // margin header
                        0);
                    $this->mpdf->WriteHTML($this->fourImagesTemplate($project, $project['categories'][$typeKey]));


                    $this->mpdf->AddPage(
                        '', // L - landscape, P - portrait
                        '', // E-even|O-odd|even|odd|next-odd|next-even
                        '', '', '',
                        15, // margin_left
                        15, // margin right
                        40, // margin top
                        60, // margin bottom
                        0, // margin header
                        0);
                    $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['companyDetails' => $this->companyDetails , 'heading' => "Inspection Details" ])->render(),'',true);
                    $this->mpdf->WriteHTML($this->surveyTemplate($project['categories'][$typeKey] /*,$whereClauses['whereSurvey']*/ ));

                    $catEstimates = [];

                    //<editor-fold desc="Estimates Main Cat">
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
                                         **/

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

                        $this->estimatesTemplate($catEstimates);
                    }
                    //</editor-fold>

                    $this->componentTemplate($project['categories'][$typeKey]);
                } else {
                    /** Additional Photos */

                    //<editor-fold desc="Additional Photos Block">
                    $selectedCatsIds = array_column([$project['categories'][$typeKey]], 'id');

                    $hasTags = false;

                    $this->mpdf->AddPage(
                        '', // L - landscape, P - portrait
                        '', // E-even|O-odd|even|odd|next-odd|next-even
                        '', '', '',
                        15, // margin_left
                        15, // margin right
                        40, // margin top
                        60, // margin bottom
                        0, // margin header
                        0);
                    $this->mpdf->SetHTMLHeader(view('reports/v2/header', [ 'heading' => 'Additional Photos' , 'project' => $this->projectDetails,'companyDetails' => $this->companyDetails ])->render(),'',true);
                    if (!empty($project['categories'][$typeKey]['media'])) {

                        $this->mpdf->WriteHTML($this->fourImagesTemplate($project, [$project['categories'][$typeKey]]));
                        foreach ($project['categories'][$typeKey]['media'] AS $mMediaKey => $mMediaItem) {
                            if (!empty($mMediaItem['media_tags_extended'])) {
                                $hasTags = true;
                            }
                        }
                    } else {
                        $this->mpdf->WriteHTML('
                        <table style="width:100%; padding:0px 50px;">
                            <tr>
                                <td style="text-align: center;">
                                    <h4> No additional photos </h4>
                                </td>
                            </tr>
                        </table> ');
                    }
                    if(!empty($hasTags)){
                        $this->componentTemplate([$project['categories'][$typeKey]]);
                    }
                    //</editor-fold>
                } /** Additional Photos End*/

                if(count(((array) $project['categories']))  == $typeCount){
                    // dd(2);
                    $this->mpdf->WriteHTML('<pagebreak />');
                }
                $typeCount++;
            }
        }/*FOR EACH*/
        }
        //</editor-fold>

        $this->termsNConditions();
        $this->addDocuments();

        $this->totalPages =  count($this->mpdf->pages);
        $this->mpdf->SetTitle($project['name']);

        /**######################## To Save File and then show via URL ########################*/
        //<editor-fold desc="To Save File and then show via URL">
        $fileName = 'project_report_' . $project['id'] . '.pdf';

        $reportPath = public_path(config('constants.PDF_PATH') . $fileName);
        $reportUrl = (env('BASE_URL') . config('constants.PDF_PATH') . $fileName);

        $this->report->path = config('constants.PDF_PATH') . $fileName;
        $this->report->save();

        //<editor-fold desc="Comment this block to stop saving the output to a file and returning its url as response">

        $this->mpdf->Output($reportPath, 'F');

        if($request['update_report']){
            return true;
        }
        $this->__collection = false;
        $this->__is_paginate = false;
        return $this->__sendResponse('Report', ['url' => $reportUrl], 200, 'Report Created Succesfully');

        //</editor-fold>

        //</editor-fold>

        /** ######################## To real-time output (useful for debugging) ########################*/
        return response($this->mpdf->Output("test","I"),200)->header('Content-Type', 'application/pdf');
    }

    public function companyIntroduction(){

//        dump($this->companyTemplates->toArray());
//        dump($this->optionsRequest);
//        dd( $this->companyTemplates->where('identifier','introduction')->values()->toArray());

//        dump(!empty($this->companyTemplates) , !empty($this->companyDetails));
//        dd($this->companyTemplates , $this->companyDetails);

        if(!empty($this->companyTemplates) AND !empty($this->companyDetails)){

            if($this->companyTemplates->where('identifier','introduction')->isNotEmpty()){
                $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails ,'heading' => 'Company Introduction' ])->render());
                $this->mpdf->AddPage(
                    '', // L - landscape, P - portrait
                    '', // E-even|O-odd|even|odd|next-odd|next-even
                    '', '', '',
                    15, // margin_left
                    15, // margin right
                    40, // margin top
                    60, // margin bottom
                    0, // margin header
                    0);

                $this->mpdf->WriteHTML(
                    view("reports/v2/introduction",
                        ['introduction' => $this->companyTemplates->where('identifier','introduction')->values()->toArray(),
                            'companyDetails' => $this->companyDetails ]
                    )->render()
                );
                $this->mpdf->SetHTMLFooter(view('reports/v2/footer', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails])->render());
            }
        }
//        return $this->output();
    }

    // /** Isn't getting used anywhere so commenting so to be retired closed in date  25 feb 22
    //  *
     public function ownerAuthorization(){
        $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails ])->render());
        $this->mpdf->AddPage(
            '', // L - landscape, P - portrait
            '', // E-even|O-odd|even|odd|next-odd|next-even
            '', '', '',
            15, // margin_left
            15, // margin right
            40, // margin top
            60, // margin bottom
            0, // margin header
            0);
        $this->mpdf->SetHTMLFooter(view('reports/v2/footer', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails])->render());
        $companyReport=$request['request_options']['owner_authorization'];
        $this->mpdf->WriteHTML(
            view("reports/v2/owner_authorization",
                ['companyDetails' => $companyReport ]
            )->render()
        );
    }

    public function termsNConditions()
    {
        if (!empty($this->companyTemplates)) {
            $terms = collect($this->companyTemplates)->where('identifier', 'terms_conditions');
            if ($terms->isNotEmpty()) {
                $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['heading' => 'Terms & Conditions', 'project' => $this->projectDetails, 'companyDetails' => $this->companyDetails])->render());
                $this->mpdf->AddPage(
                    '', // L - landscape, P - portrait
                    '', // E-even|O-odd|even|odd|next-odd|next-even
                    '', '', '',
                    15, // margin_left
                    15, // margin right
                    40, // margin top
                    60, // margin bottom
                    0, // margin header
                    0);
                $this->mpdf->SetHTMLFooter(view('reports/v2/footer', ['project' => $this->projectDetails, 'companyDetails' => $this->companyDetails])->render());
                $this->mpdf->WriteHTML(
                    view("reports/v2/terms_n_conditions",
                        [
                            'companyDetails' => $this->companyDetails,
                            'termsNConditions' => $terms->all(),
                            'report' => $this->report
                        ]
                    )->render()
                );
            }
        }
    }

    public function addDocuments(){

        if(!empty($this->companyTemplates)){

            $docs = $this->companyTemplates->where('identifier','documents')->map(function($template){
                $template->path = base_path("public/{$template->path}");
                return $template;
            });

            $filesTotal = sizeof($docs);
            $fileNumber = 1;

            if(!empty($docs)){
                foreach ($docs AS $template){

                    if (file_exists($template->path)) {
                        $pagesInFile = $this->mpdf->SetSourceFile($template->path);

//                        $this->mpdf->SetHTMLHeader(view('reports/v2/header', [ 'heading' => "{$template->title}" , 'project' => $this->projectDetails,'companyDetails' => $this->companyDetails ])->render());

                        $this->mpdf->SetHTMLHeader();
                        $this->mpdf->SetHTMLFooter();
                        for ($i = 1; $i <= $pagesInFile; $i++) {
                            $tplId = $this->mpdf->importPage($i); // in mPdf v8 should be 'importPage($i)'

                            $size = $this->mpdf->getTemplateSize($tplId);

                            $this->mpdf->AddPage($size['orientation'], // L - landscape, P - portrait
                                '', // E-even|O-odd|even|odd|next-odd|next-even
                                '', '', '',
                                15, // margin_left
                                15, // margin right
                                40, // margin top
                                60, // margin bottom
                                0, // margin header
                                0);

                            //$this->mpdf->useTemplate($tplId, 0, 20, $size['width'], $size['height'], true);
                            $this->mpdf->useTemplate($tplId, 0, 20, $size['width'], $size['height']);

                            if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                                $this->mpdf->WriteHTML('<pagebreak />');
                            }
                        }
                    }
                }
            }
        }
    }

    /*New 4 Images template*/
    public function fourImagesTemplate($project, $category)
    {
        $html = '';
        if (/*FALSE*/ TRUE ) {
            foreach ($category AS $mainKey => $item) {

                $category[$mainKey]['media_count'] += count(((array) $item['media']));
                $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['companyDetails' => $this->companyDetails , 'heading' => $item['category_name'] ])->render(),'',true);

                /** CHILD **/
                if (!empty($category[$mainKey]['get_child']) /*FALSE*/) {
                    foreach ($category[$mainKey]['get_child'] AS $subKey => $subItem) {
                        $category[$mainKey]['get_child'][$subKey]['media_count'] += count(((array) $subItem['media']));
                    }
                }
            }
            $html .= view('reports/v2/four_images', ['project' => $this->projectDetails , 'companyDetails' => $this->companyDetails ,'category' => $category])->render();
//            $html.="<pagebreak/>";
        }
        return $html;
    }

    public function surveyTemplate($category, $whereSurvey = [])
    {
//        dd('$category',$category);
        $html = '';
        foreach ($category AS $cKey => $cItem) {
            // IF in_array($cItem['id'], $whereSurvey)

            if(!empty($cItem['survey'])){
                $data = [
                    'survey' => $cItem['survey'],
                    'category_name' => $cItem['category_name'],
                    'companyDetails' => $this->companyDetails,
                ];

                $html .= view('reports/v2/inspection_details', $data);
//                $html .= "<pagebreak />";
//                $this->mpdf->WriteHTML('<pagebreak />');
            }
        }
        return $html;
    }

    public function estimatesTemplate($data){
        $this->mpdf->AddPage(
            '', // L - landscape, P - portrait
            '', // E-even|O-odd|even|odd|next-odd|next-even
            '', '', '',
            15, // margin_left
            15, // margin right
            40, // margin top
            60, // margin bottom
            0, // margin header
            0);
        $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['companyDetails' => $this->companyDetails , 'heading' => "Estimates" ])->render(),'',true);
        $this->mpdf->WriteHTML(view('reports/v2/estimates', ['estimates'=> $data ,
            'companyDetails' => $this->companyDetails ,
            'report' => $this->report , 'projectDetails' => $this->projectDetails,'userDetails' => $this->userDetails ,
            'ownerAuthorization' => $this->ownerAuthorization ])->render());
    }

    /** Soon to be retired closed in date  25 feb 22
     * public function estimatesTemplate_2($catEst){
        $view = view('reports/v2/estimates_2', ['estimates'=> $catEst , 'heading' => 'heading from con'])->render();
        return $view;
    }*/

    public function addSignImage(){

        $this->mpdf->AddPage(
            '', // L - landscape, P - portrait
            '', // E-even|O-odd|even|odd|next-odd|next-even
            '', '', '',
            15, // margin_left
            15, // margin right
            40, // margin top
            60, // margin bottom
            0, // margin header
            0);
        $url = url(config('constants.SIGN_PATH')."customer_sign1641124325.svg");
        $this->mpdf->WriteHTML("<table>
                    <tr><td><h1>SIGNED: </h1></td></tr>
                    <tr><td><img src='$url' alt='sign_image'/></td></tr>
                    </table>");

    }

    public function componentTemplate($categories)
    {
        $categories = collect($categories);

        if($categories->where('media_tags','t')->isNotEmpty()){

            $this->mpdf->AddPage(
                '', // L - landscape, P - portrait
                '', // E-even|O-odd|even|odd|next-odd|next-even
                '', '', '',
                15, // margin_left
                15, // margin right
                40, // margin top
                60, // margin bottom
                0, // margin header
                0);

            $this->mpdf->SetHTMLHeader(view('reports/v2/header', ['companyDetails' => $this->companyDetails , 'heading' => "Component List" ])->render(),'',true);
            // view('reports/v2/component', ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails, 'categories' => $categories])->render();
            $this->mpdf->WriteHTML(
                view('reports/v2/component',
                    ['project' => $this->projectDetails,'companyDetails' => $this->companyDetails, 'categories' => $categories]
                )->render());
        }
    }

    public function output(){
        return response($this->mpdf->Output('test.pdf',"I"),200)->header('Content-Type','application/pdf');
    }

    public function webSample(Request $request){

        return view("reports.test");
    }

    public function hello(Request $request){

        $sign = new HelloSign();
        $sign->authentication();
        $sign->sign();
    }

    public function signNow(Request $request){

        $sign = new SignNow();
        $sign->authentication();
//        $sign->sign();
    }

    public function store(Request $request)
    {
        $this->__view = 'subadmin/tag';
        $this->__is_redirect = true;

        $param_rules['company_id'] = 'required|int';
        $param_rules['name'] = 'required|string|max:100';
        $param_rules['has_qty'] = 'required|int';
        $param_rules['category_id'] = 'required|int';
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        $tag = new Tag();
        $tag['company_id']  =   $request['company_id'];
        $tag['category_id'] =   $request['category_id'];
        $tag['name']        =   $request['name'];
        $tag['has_qty']     =   $request['has_qty'];

        if (!$tag->save()) {
            return $this->__sendError('Query Error', 'Unable to add record.');
        }

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
    }

    public function customerSignView($token){

        $report = Report::where(['token' => $token])->first();

        if(!$report->exists && !empty($report->is_signed)){
            return redirect('home');
        }
        return view("web.report_sign",['report' => $report]);
    }

    public function customerSign(Request $request,$token){

        $report = Report::with(['project'])->where(['token' => $token])->first();

        if(!$report->exists){
            return redirect('home');
        }

        if ($request->isMethod('post')) {
            if (preg_match('/^data:image\/(\w+)\+(\w+);base64,/', $request['signature_url'])) {

                $value = substr($request['signature_url'], strpos($request['signature_url'], ',') + 1);
                $value = base64_decode($value);
                $imagePath = public_path(config('constants.SIGN_PATH'));
                if(!is_dir($imagePath)){
                    mkdir($imagePath);
                }

                if (empty($report->customer_sign) AND base_path()) {
                    $imageName = 'customer-sign-' . time() . '-' . rand() . '.svg';
                } else {
                    $imageName = pathinfo($report->customer_sign)['basename'];
                }

                if(file_put_contents("{$imagePath}/{$imageName}",$value)){
                    $report->customer_sign = config('constants.SIGN_PATH')."{$imageName}";
                    $report->customer_sign_at = Carbon::now();
                    $report->is_signed = 1;
                    $report->save();

                    \Log::debug('report',$report->toArray());

                    //<editor-fold desc="Update Report">
                    $reportRequest = new Request();
                    $reportRequest->setMethod('POST');
                    $reportRequest->request->add([
                        'request_options' => json_decode($report->options,true),
                        'user_id' => $report->user_id,
                        'update_report' => true
                    ]);

                    $updateReport = $this->createReport($reportRequest,$report->project_id);
                    //</editor-fold>

                    if(!empty($report->customer_sign) && !empty($report->inspector_sign) && $updateReport){
                        $mailParams['LINK'] = url("report/sign/{$report->token}");
                        $mailRes = $this->__sendMail('report_summary',$report->project->customer_email,$mailParams);
                    }
                }
            }
        }

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__collection = false;
        return $this->__sendResponse('Report',[],200,'Your signature for consent on the report is added. Thanks!');
    }

    public function addSign(Request $request){

        $this->__collection = false;
        $this->__is_paginate = false;

        //<editor-fold desc="Validation">
        $param_rules['sign'] = "required|image|mimes:jpeg,svg,png";
        $param_rules['identifier'] = "required|in:customer,inspector";
        $param_rules['project_id'] =
            [
                'required',
                'int',
                Rule::exists('reports', 'project_id')->whereNull('deleted_at')
            ];

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == TRUE)
            return $response;
        //</editor-fold>

        $report = Report::where(['project_id' => $request['project_id']])->first();

        if(empty($report)){
            return $this->__sendError('Report Not Found',[],400);
        }

        $identifierColName = $request['identifier'].'_sign';

        if ($request->hasFile('sign')) {
            $signPath = config('constants.SIGN_PATH');
            $newFileName = "{$request['identifier']}-sign-" . time() . '-' . rand();

            /** IF IMAGE EXISTS Overwrite that*/
            if(!empty($report->$identifierColName)){
                $pathInfo = pathinfo($report->$identifierColName);
                $imageName = (strpos($pathInfo['filename'],'.') > 0) ? $pathInfo['filename'] : $newFileName;
            }else{
                $imageName = $newFileName;
            }

            $uploadedName = $this->__moveUploadFile(
                $request->file('sign'),
                $imageName,
                $signPath
            );

            $report->$identifierColName = $signPath.$uploadedName;
            $report->{$identifierColName.'_at'} = Carbon::now();

            if($report->save()){
                return $this->__sendResponse('Report',[],200,'Sign Added Successfully');
            }
        }

        return $this->__sendError('Sign failed to be added',['Sign failed to be added'],400);
    }

    public function sendCustomerSignMail(Request $request){
        $this->__collection = false;
        $this->__is_paginate = false;

        //<editor-fold desc="Validation">
        $param_rules['project_id'] =
            [
                'required',
                'int',
                Rule::exists('reports', 'project_id')->whereNull('deleted_at')
            ];

        $response = $this->__validateRequestParams($request->all(), $param_rules);

        if ($this->__is_error == TRUE)
            return $response;
        //</editor-fold>

        $report = Report::selectRaw("reports.*,project.customer_email,inspector.id AS inspector_id,inspector.first_name AS inspector_first_name,inspector.last_name AS inspector_last_name,inspector.email AS inspector_email")
            ->join('project','project.id','reports.project_id')
            ->join('user AS inspector','inspector.id','project.assigned_user_id')
            ->where(['project_id' => $request['project_id']])->first();


        //<editor-fold desc="Secondary Validation">
        if(empty($report->inspector_sign)){
            return $this->__sendError("Report isn't signed by inspector", [], 400);
        }

        if(empty($report->customer_email)){
            return $this->__sendError("Customer Email Not Found", [], 400);
        }
        //</editor-fold>

        $mailParams['LINK'] = url("report/sign/{$report->token}");
        $mailParams['APP_URL'] = url('');

        $mailParams['INSPECTOR_FIRST_NAME'] = $report->inspector_first_name;
        $mailParams['INSPECTOR_LAST_NAME'] = $report->inspector_last_name;
        $mailParams['INSPECTOR_EMAIL'] = $report->inspector_email;
        // [CUSTOMER_FIRST_NAME],[CUSTOMER_LAST_NAME]

//        dd($report->toArray());

        $emailIdentifier = !empty($report->customer_sign) ? 'report_summary': 'report_customer_sign';

        $mailRes = $this->__sendMail($emailIdentifier,$report->customer_email,$mailParams);

        $report->is_signed = 0;
        $report->save();

        if($mailRes){
            return $this->__sendResponse('Report',[],200,'Send to customer for signing');
        }
    }

    public function getReportLink(Request $request){

    }

    //<editor-fold desc="Report Management Web-Panel">
    public function listView(Request $request){

        $report    = CompanyReport::where(['company_id' => $request->company_id ])->first();
        $templates = ReportTemplate::where(['company_id' => $request->company_id ])->get();
        $data['documents']       = ReportTemplate::where('company_id',$request->company_id)->where('identifier','documents')->get();
        $data['introductions']   = ReportTemplate::where('company_id',$request->company_id)->where('identifier','introduction')->first();
        $data['termsConditions'] = ReportTemplate::where('company_id',$request->company_id)->where('identifier','terms_conditions')->first();
        $data['report']    = $report;
        $data['templates'] = $templates;
        return view('subadmin/report_mgmt',$data);
    }

    public function storeLogo(Request $request)
    {
        $this->__view = 'subadmin/report';

        $param_rules['logo'] = 'required_unless:image_set,true|image|mimes:jpeg,bmp,png';
        $messages['required_unless'] = "The logo field is required";
        $response = $this->__validateRequestParams($request->all(), $param_rules, $messages);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Updated Successfully' , $error['data']);
            return $response;
        }

        if($request['image_set']){
            $this->__is_paginate = false;
            $this->__is_collection = false;
//            $this->__setFlash('success', 'Added Successfully');
            $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
        }

        if ($request->hasFile('logo')) {
            // $obj is model
            $uploadedLogo = $this->__moveUploadFile(
                $request->file('logo'),
                md5($request['email'] . $request['device_token']),
                "{$this->templatesPath}/logo"
            );
            $logoUpdate = CompanyReport::updateOrCreate(['company_id' => $request->company_id],['logo_path' => "logo/".$uploadedLogo]);
        }

//        $this->__setFlash('success', 'Added Successfully');
        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Tag', [], 200,'Logo Uploaded successfully.');
    }

    public function storeInfo(Request $request)
    {
        $this->__view = 'subadmin/report';
        $this->__is_redirect = true;

        //<editor-fold desc="Validation">
        if(!empty($request['name']) OR !empty($request['email']) OR !empty($request['phone']) OR !empty($request['website']) OR !empty($request['services'])){
            $param_rules['name'] = "required|min:3|max:50";
            $param_rules['email'] = "required|min:3|max:50";
            $param_rules['phone'] = "required|min:3|max:50";
            $param_rules['website'] = "required|min:3";
            $param_rules['services'] = "required|min:3|max:500";
        }else if(!empty($request['credit_disclaimer']) OR !empty($request['is_disclaimer'])){
            $param_rules['credit_disclaimer'] = "required|min:3";
            $param_rules['is_disclaimer'] = "required|in:0,1";
        }



        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        $cReport = CompanyReport::firstOrNew(['company_id' => $request->company_id]);

        $cReport->fill($request->all());

//        dd($cReport->getAttributes());

        $cReport->save();

        /*$addFields = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'services' => $request->services,
        ];
        CompanyReport::updateOrCreate(['company_id' => $request->company_id],$addFields);*/

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
    }

    public function storeCoverInfo(Request $request)
    {
        $this->__view = 'subadmin/report';
        $this->__is_redirect = true;

        //<editor-fold desc="Validation">
        $param_rules['report_name'] = "required|min:3|max:50";
        $param_rules['cover_image'] = "required_unless:image_set,true|image|mimes:jpeg,bmp,png";
        $param_rules['user_name']    = "nullable|in:true,false";
        $param_rules['user_email']    = "nullable|in:true,false";
        $param_rules['user_number']  = "nullable|in:true,false";
        $messages['required_unless'] = "The logo field is required";
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        if ($request->hasFile('cover_image')) {
            // $obj is model
            $uploadedLogo = $this->__moveUploadFile(
                $request->file('cover_image'),
                md5($request['email'] . $request['device_token']),
                "{$this->templatesPath}/cover"
            );
//            $logoUpdate = CompanyReport::updateOrCreate(['company_id' => $request->company_id],['logo_path' => "logo/".$uploadedLogo]);
        }

        $addFields = [
            'report_name' =>  $request->report_name,
            'is_footer_user_name'   =>  $request->user_name == 'true' ? 1 : 0 ,
            'is_footer_user_email'  =>  $request->user_email == 'true' ? 1 : 0 ,
            'is_footer_user_phone'  =>  $request->user_number == 'true' ? 1 : 0 ,
        ];

        if(!$request['image_set']){
            $addFields['report_cover_image'] = "cover/".$uploadedLogo;
        }


        CompanyReport::updateOrCreate(['company_id' => $request->company_id],$addFields);

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Tag added successfully.');
    }

    public function storeIntroduction(Request $request){
        $this->__view = 'subadmin/report';
        $this->__is_redirect = true;

//        dd($request->all());

        //<editor-fold desc="Validation">
        $param_rules['title'] = "required|min:3|max:100";
        $param_rules['editor1'] = "required|min:3";
        $param_rules['id'] = "nullable|int";
        $messages['editor1.required'] = "The Introduction field is required";
        $response = $this->__validateRequestParams($request->all(), $param_rules);
        if ($this->__is_error == true){
            $error = \Session::get('error');
            $this->__setFlash('danger','Not Added Successfully' , $error['data']);
            return $response;
        }
        //</editor-fold>

        $request['content'] = $request['editor1'];

        $where = ['id' => $request->template_id,'company_id' => $request->company_id , 'identifier' => 'introduction'];

        $reportTemplate = new ReportTemplate();
        $cReport = $reportTemplate->firstOrNew($where);
        $cReport->fill($request->all());
        $cReport->save();

        $this->__setFlash('success', 'Added Successfully');
        $this->__is_paginate = false;
        $this->__is_collection = false;
        return $this->__sendResponse('Tag', [], 200,'Introduction added successfully.');
    }

    public function getIntroduction(Request $request){

        $report = ReportTemplate::find($request->id);


        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Tag',$report, 200,'Introduction added successfully.');
//        return response()->json(['json' => true]);
    }

    public function deleteIntroduction(Request $request){

        $report = ReportTemplate::where('id',$request->id)->delete();

        $this->__is_ajax = true;
        $this->__is_paginate = false;
        $this->__is_collection = false;
        $this->__collection = false;
        return $this->__sendResponse('Tag',$report, 200,'Introduction added successfully.');
//        return response()->json(['json' => true]);
    }

    public function companyColor(Request $request)
    {
       \DB::table('company_reports')
          ->where('company_id',$request['company_id'])
          ->update([
             'primary_color'   => $request['primary_color'],
             'secondary_color' => $request['secondary_color'],
          ]);
       return redirect()->back()->with('success','Company color added successfully');
    }

    public function companyTermsConditions(Request $request)
    {
        //delete old data
        \DB::table('report_templates')
            ->where('company_id',$request['company_id'])
            ->where('identifier','terms_conditions')
            ->delete();
        //insert new data
        \DB::table('report_templates')
            ->insert([
               'company_id' => $request['company_id'],
               'identifier' => 'terms_conditions',
               'content'    => $request['editor2']
            ]);
        return redirect()->back()->with('success','Company terms & conditions added successfully');
    }

    public function reportIntroduction(Request $request)
    {
         //delete old data
        \DB::table('report_templates')
            ->where('company_id',$request['company_id'])
            ->where('identifier','introduction')
            ->delete();
        //insert new data
        \DB::table('report_templates')
            ->insert([
               'company_id' => $request['company_id'],
               'identifier' => 'introduction',
               'title'      => $request['title'],
               'content'    => $request['editor1']
            ]);
        return redirect()->back()->with('success','Company terms & conditions added successfully');
    }

    public function saveDocument(Request $request)
    {
        $uploadedDocument = '';
        if ($request->hasFile('document')) {
            // $obj is model
            $uploadedDocument = $this->__moveUploadFile(
                $request->file('document'),
                md5(time() . uniqid()),
                "{$this->templatesPath}document"
            );
        }
         \DB::table('report_templates')
            ->insert([
               'company_id' => $request['company_id'],
               'identifier' => 'documents',
               'title'      => $request['title'],
               'path'       => !empty($uploadedDocument) ? "{$this->templatesPath}/document/" . $uploadedDocument : NULL,
            ]);
        return redirect()->back()->with('success','Company terms & conditions added successfully');
    }

    public function deleteDocument(Request $request)
    {
         $path = $request['path'];
         \DB::table('report_templates')
            ->where('company_id',$request['company_id'])
            ->where('identifier','documents')
            ->whereRaw("md5(path) = '$path' ")
            ->delete();
         return response()->json(['code' => 200, 'message' => 'Document deleted successfully']);
    }

    public function storeOwnerAuthorization(Request $request)
    {
        $json_data = [];
        if( !empty($request['section_item']) ){
           for( $i=0; $i < count($request['section_item']); $i++ )
           {
               $json_data['section_item']['item'][]  = $request['section_item'][$i];
               $json_data['section_item']['price'][] = $request['section_price'][$i];
           }
        } else {
            $json_data['section_item']['item'][]  = [];
            $json_data['section_item']['price'][] = [];
        }
        $json_data['item_option'] = !empty($request['item_option']) ? $request['item_option'] : [];
        \DB::table('company_reports')
            ->where('company_id',$request['company_id'])
            ->update([
                'estimate_terms'    => $request['estimate_terms'],
                'footer_disclaimer' => $request['footer_disclaimer'],
                'json_data'         => !empty($json_data) ? json_encode($json_data) : null
            ]);
        return redirect()->back()->with('success','Company terms & conditions added successfully');
    }
    //</editor-fold>

}