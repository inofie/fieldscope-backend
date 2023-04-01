<?php
/**
 * Created by PhpStorm.
 * User: developer_retrocube
 * Date: 8/8/2019
 * Time: 10:42 AM
 */

namespace App\Libraries;
use App\Models\CrmModel;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class EagleView
{
    private $_response,$_baseUrl,$_debug;
    private $sourceId =  'b7afd8b7-d78d-205b-d1b6-0743c792a436', $clientSecret = 'X4MAM8JZ20W65OXCQLNHCW93834RGGQJ8Z5GU4SL8ZZ4X8P65ZOCZNP3ED2P1KJ3';
    public $_accessToken,$_refreshToken,$_tokenType, $_accessTokenExpiresAt, $response,$_company;
    public $_payloadType = [
        'raw' => 'body',
        'params' => 'params',
        'form_data' => 'form_params'
    ];
    public $_headers = [
        'Content-Type' => 'application/x-www-form-urlencoded',
//        'Authorization' => 'Basic YjdhZmQ4YjctZDc4ZC0yMDViLWQxYjYtMDc0M2M3OTJhNDM2Olg0TUFNOEpaMjBXNjVPWENRTE5IQ1c5MzgzNFJHR1FKOFo1R1U0U0w4Wlo0WDhQNjVaT0NaTlAzRUQyUDFLSjM=',
    ];

    public $_order = [
        'OrderReports' => [
            [
                'ReportAddresses' => [
                    [
                        'Address' => '',
                        'City' => '',
                        'State' => '',
                        'Zip' => '',
                        'Country' => '',
                        'Latitude' => '',
                        'Longitude' => '',
                        'AddressType' => '',
                    ]
                ],
                'PrimaryProductId' => 31,
                'DeliveryProductId' => 8,

                'MeasurementInstructionType' => 0,
                'ClaimNumber' => 0,
                'ChangesInLast4Years' => 0,
                'AddOnProductIds' => [

                ],
            ]
        ]
    ];

    //<editor-fold desc="Report">
    public $_report = "{
    \"ReportId\": 41012735,
    \"Street\": \"Downtown Los Angeles, Los Angeles, CA 90021, USA\",
    \"BuildingId\": null,
    \"City\": \"Los Angeles\",
    \"State\": \"CA\",
    \"Zip\": \"90021\",
    \"Latitude\": 34.0404230,
    \"Longitude\": -118.2467790,
    \"ClaimNumber\": \"sample string 4\",
    \"ClaimInfo\": null,
    \"BatchId\": null,
    \"CatId\": null,
    \"DatePlaced\": \"2020-10-14T03:01:18.25\",
    \"DateCompleted\": \"2020-10-14T03:05:03.47\",
    \"PONumber\": null,
    \"Comments\": null,
    \"ReportImage\": [],
    \"ReferenceId\": null,
    \"InsuredName\": null,
    \"MeasurementRequestType\": 2,
    \"ReportDownloadLink\": \"https://my-stage.eagleview.com/DesktopModules/services/api/file/Download/OWtIWlFyS1c1TWUzcVRXWjZqY3V2UT09\",
    \"EligibleForUpgrade\": false,
    \"Status\": \"Completed\",
    \"Area\": \"1885 sq. ft\",
    \"Pitch\": \"6/12\",
    \"LengthRidge\": \"83 ft\",
    \"LengthValley\": \"52 ft\",
    \"LengthEave\": \"96 ft\",
    \"LengthRake\": \"102 ft\",
    \"ProductPrimaryId\": 31,
    \"ProductPrimary\": \"Premium - Residential\",
    \"ProductDeliveryId\": 8,
    \"ProductDelivery\": \"Regular Delivery\",
    \"AddOnProductIds\": null,
    \"AllowsUserSubmittedPhotos\": true,
    \"LengthHip\": \"0 ft\",
    \"ProfileId\": 0,
    \"UserName\": null,
    \"SubstituteFromProduct\": null,
    \"SubstituteToProduct\": null,
    \"CanCancelReport\": false,
    \"StatusId\": 5,
    \"SubStatusId\": 19,
    \"DisplayStatus\": \"Completed\",
    \"DateOfLoss\": \"\",
    \"DeliveryFilesAvailable\": [
        {
            \"DeliveryFileTypeId\": 6,
            \"EffectiveDate\": \"2020-10-14T03:01:47.497\"
        },
        {
            \"DeliveryFileTypeId\": 22,
            \"EffectiveDate\": \"2020-10-14T03:01:50.527\"
        },
        {
            \"DeliveryFileTypeId\": 23,
            \"EffectiveDate\": \"2020-10-14T03:01:53.497\"
        },
        {
            \"DeliveryFileTypeId\": 25,
            \"EffectiveDate\": \"2020-10-14T03:01:53.527\"
        },
        {
            \"DeliveryFileTypeId\": 24,
            \"EffectiveDate\": \"2020-10-14T03:01:53.573\"
        },
        {
            \"DeliveryFileTypeId\": 18,
            \"EffectiveDate\": \"2020-10-14T03:02:48.087\"
        },
        {
            \"DeliveryFileTypeId\": 2,
            \"EffectiveDate\": \"2020-10-14T03:02:48.157\"
        },
        {
            \"DeliveryFileTypeId\": 107,
            \"EffectiveDate\": \"2020-10-14T03:02:48.263\"
        },
        {
            \"DeliveryFileTypeId\": 75,
            \"EffectiveDate\": \"2020-10-14T03:02:48.717\"
        },
        {
            \"DeliveryFileTypeId\": 75,
            \"EffectiveDate\": \"2020-10-14T03:03:25.183\"
        }
    ],
    \"AdditionalRecipients\": \"\",
    \"TotalCost\": null,
    \"PaymentType\": \"-\",
    \"MeasurementByStructure\": [
        {
            \"BuildingName\": \"Building 1\",
            \"Area\": \"1885 sq. ft\",
            \"PrimaryPitch\": \"6/12\",
            \"LengthRidge\": \"83 ft\",
            \"LengthValley\": \"53 ft\",
            \"LengthEave\": \"96 ft\",
            \"LengthRake\": \"104 ft\",
            \"LengthHip\": \"0 ft\",
            \"AreaValue\": 0.0,
            \"PitchValue\": null,
            \"WallMeasurement\": null
        }
    ],
    \"PrimaryProductDisplayName\": \"Premium\",
    \"AddOnProducts\": [],
    \"TypeOfStructure\": 1,
    \"ProductSubstitution\": null,
    \"TotalMeasurements\": {
        \"BuildingName\": null,
        \"Area\": \"1885 sq. ft\",
        \"PrimaryPitch\": \"6/12\",
        \"LengthRidge\": \"83 ft\",
        \"LengthValley\": \"53 ft\",
        \"LengthEave\": \"96 ft\",
        \"LengthRake\": \"104 ft\",
        \"LengthHip\": \"0 ft\",
        \"AreaValue\": 1885.0,
        \"PitchValue\": 6.0,
        \"WallMeasurement\": null
    },
    \"JobName\": null,
    \"CanEditReportInformation\": false,
    \"SuggestedWasteFactorAvailable\": true
}";
    //</editor-fold>


    public function __construct($company)
    {
        $this->response = [
            'code'    => 200, //status code
            'data' => [] ,//data
            'message' => ''
        ];

        $this->_baseUrl = env('EAGLEVIEW_BASE_URL','https://webservices-integrations.eagleview.com/');
        $this->_debug = false;
        $this->_company = $company;

        $this->authenticate();
    }

    public function getAuthToken(){
        return base64_encode($this->sourceId.':'.$this->clientSecret);
    }

    public function makeRequest($method, $url , $payloadType = '' ,$payload = []){
        $client = new \GuzzleHttp\Client();
        //$response = new \stdClass();
        $exception = NULL;
        try {

            $payloadType = !empty($payloadType) ? $payloadType : $this->_payloadType['form_data'];

            $requestOptions = [
//                'debug' => $this->_debug,
                'headers' => $this->_headers,
                $payloadType => $payload
            ];
            if($this->_debug)
            $requestOptions['debug'] = $this->_debug;

            if($this->_debug){
//                $requestOptions['debug'] = true;
                p($this->_baseUrl . $url,'MAKE Req:  Request URL: ');
                p([
                    $payloadType => $payload,
                    'headers' => $this->_headers
                ],'MAKE Req: PARAM' );
            }

            $response = $client->request(
                $method, /*METHOD */
                $this->_baseUrl . $url, /*URL*/
                $requestOptions
            );

        } catch (RequestException $e) {
            $this->response['code'] = 400; # 400
            $this->response['headers'] = $e->getRequest()->getHeaders(); # 'application/json; charset=utf8'

//            pd($e->getResponse()->getBody()->getContents(),'$e->getBody()->getContents()');

            Log::error("app/Libraries/EagleView.php/makeRequest() - Exception - ".$e->getMessage()." @".$url,$e->getRequest()->getHeaders());

            //<editor-fold desc="DONT REMOVE COMMENT contains useful methods">
            //            if ($e->hasResponse()) {
//
//                $contentType = $e->getResponse()->getHeader('Content-Type');
//                Helper::p($e->getResponse()->getStatusCode(),'getStatusCode');
//                Helper::p($e->getResponse()->getHeaders(),'getHeaders');
//                Helper::pd($e->getBody()->getContents(),'getBody');
//                Helper::pd($e->getResponse()->getBody()->getContents(),'getBody');
//
//                if (strpos($contentType[0], ';')) {
//                    echo "LIST:<br>";
//                    list($contentType, ) = explode(';', $contentType[0]);
//                }
//            }
            //</editor-fold>
        }

        if(!empty($response)){
            $this->response['code']        =  $response->getStatusCode(); # 200
            $this->response['headers']     =  $response->getHeaders(); # 'application/json; charset=utf8'
            $this->response['data']        = json_decode($response->getBody()->getContents(),TRUE); # '{"id": 1420053, "name": "guzzle", ...}'

            Log::info("app/Libraries/Crm.php/makeRequest() - @".$url,$response->getHeaders());

            return $this->response;
        } else {
            Log::error("app/Libraries/Crm.php/makeRequest() - Response Empty");
            return $this->response;
        }
    }

    //<editor-fold desc="Make Request Backup">
//    public function makeRequest1($method, $url , $payload = []){
//        $client = new \GuzzleHttp\Client();
//
//        try {
//            $response = $client->request(
//                $method,
//                $this->_baseUrl.$url,
//                [
//                    'form_params' => $payload,
//                    'headers' => $this->_headers
//                ]
//            );
//        } catch (RequestException $e) {
//            /*echo"<br>getRequest:<br><br>";
//            echo Psr7\str($e->getRequest());*/
//            if ($e->hasResponse()) {
//                $contentType = $e->getResponse()->getHeader('Content-Type');
////                echo Psr7\str($e->getResponse());
//                /*echo"<br>getResponse:<br><br>";
//                Helper::pd($contentType[0],'$contentType');*/
//
//                if (strpos($contentType[0], ';')) {
//                    list($contentType, ) = explode(';', $contentType[0]);
//                }
//
//                if($contentType == 'text/html'){
//                    echo "HTML";
//                }
//
//            }else{
//
//            }
//        }
//
//        print_r($response);
//        exit;
//        $this->_response['code']    =  $response->getStatusCode(); # 200
//        $this->_response['headers']  =  $response->getHeaders(); # 'application/json; charset=utf8'
//        $this->_response['data']    = json_decode($response->getBody()->getContents()); # '{"id": 1420053, "name": "guzzle", ...}'
//        return $this->_response;
//    }
    //</editor-fold>

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function authenticate(){

        $this->_headers['Authorization'] = "Basic ".$this->getAuthToken();

        $crmModel = CrmModel::where(['identifier' => 'eagle_view' ,'company_id' =>  $this->_company['id'] ])->first();

//        pd($crmModel->toArray(),'$crmModel');

        if($this->_debug) {
            p($crmModel->toArray(), '$crmModel');
        }

        $expiresAt = new Carbon($crmModel->expires_at);
        $today = Carbon::now();

//         Helper::p($today,'$today');
//         Helper::p($expiresAt,'$expiresAt');
//         Helper::v($today->lt($expiresAt),'$today->lt($expiresAt)');

        if(empty($crmModel->access_token) AND empty($crmModel->refresh_token) ){

            if($this->_debug) echo "<br> New Token";
            /** New Token */
            $payload['grant_type']= 'password';
            $payload['username']    = $this->_company['ev_email'];
            $payload['password']    = $this->_company['ev_password'] ;

            /** Making Login Request*/
            $this->response = $this->makeRequest('POST' ,'token' ,'', $payload);

        }else if($today->gt($expiresAt)){

            if($this->_debug) echo "<br> Refresh Token";

            /** Refresh Token */
            $payload['grant_type']= 'refresh_token';
            $payload['refresh_token']= $crmModel->refresh_token;

            /** Making Login Request*/
            $this->response = $this->makeRequest('POST' ,'token' ,'', $payload);

            if($this->response['code'] != 200){
                if($this->_debug) echo "<br> New Token 2";
                /** New Token */
                $payload['grant_type']= 'password';
                $payload['username']    = $this->_company['ev_email'];
                $payload['password']    = $this->_company['ev_password'] ;

                /** Making Login Request*/
                $this->response = $this->makeRequest('POST' ,'token' ,'', $payload);
            }
        }else{
            if($this->_debug) echo "<br> Else";
        }

//        p($this->response['message'],'authenticate > $this->response[\'message\']');
//        pd($this->response['data'],'authenticate > $this->response[\'data\']');

        /** Updating new tokens in DB*/
        if(!empty($this->response['data'])){
            $crmModel->access_token     = $this->response['data']['access_token'];
            $crmModel->refresh_token    = $this->response['data']['refresh_token'];
            $crmModel->token_type       = $this->response['data']['token_type'];
            $crmModel->expires_at       = date('Y-m-d H:i:s',strtotime($this->response['data']['.expires']));
            $crmModel->save();
        }

        $this->_accessToken             = $crmModel->access_token;
        $this->_refreshToken            = $crmModel->refresh_token;
        $this->_tokenType               = $crmModel->token_type;
        $this->_accessTokenExpiresAt    = $crmModel->expires_at;

        return $this->response;
    }

    public function getAvailableProducts(){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $uri = 'v2/Product/GetAvailableProducts';
        $this->response = $this->makeRequest('GET' ,$uri , []);

        if($this->response['code'] == 200){
        }

        return $this->response;
    }

    public function intializeOrder ($request, $project){

//        $order = $this->_order;
        $order = [];
        //@formatter:off
        $order['OrderReports'][0]['PrimaryProductId']           = (int)$request['primary_product_id'];
        $order['OrderReports'][0]['DeliveryProductId']          = (int)$request['delivery_product_id'];
        $order['OrderReports'][0]['MeasurementInstructionType'] = (int)$request['measurement_instruction_type'];
        $order['OrderReports'][0]['ClaimNumber']                = $project['claim_num'];
        $order['OrderReports'][0]['ChangesInLast4Years']        = (bool) $request['changes_in_last_4_years'];
        $order['OrderReports'][0]['AddOnProductIds']            = (!empty($request['addon_product_ids'])) ? array_map('intval', $request['addon_product_ids']) : [] ;

        $order['OrderReports'][0]['ReportAddresses'][0]['Address']     = !empty($project['address1']) ? $project['address1'] : $request['address'];
        $order['OrderReports'][0]['ReportAddresses'][0]['Country']     = !empty($project['complete_address']['country_name'])   ? $project['complete_address']['country_name']: $request[''] ;
        $order['OrderReports'][0]['ReportAddresses'][0]['City']        = !empty($project['complete_address']['name'])           ? $project['complete_address']['name']: $request['city'] ;
        $order['OrderReports'][0]['ReportAddresses'][0]['State']       = !empty($project['complete_address']['state_name'])     ? $project['complete_address']['state_name']: $request['state'] ;
        $order['OrderReports'][0]['ReportAddresses'][0]['Zip']         = !empty($project['postal_code'])    ?   $project['postal_code'] : $request['postal_code'];

        $lat =  0;
        $long = 0;
        $addressType = 1;
        if (!empty($project['latitude']) AND !empty($project['longitude'])) {
            $lat = $project['latitude'];
            $long = $project['longitude'];
            $addressType = 4;
        } else if (!empty($request['latitude']) AND !empty($request['longitude'])) {
            $lat = $request['latitude'];
            $long = $request['longitude'];
            $addressType = 4;
        }

        $order['OrderReports'][0]['ReportAddresses'][0]['Latitude']    = $lat;
        $order['OrderReports'][0]['ReportAddresses'][0]['Longitude']   = $long;
        $order['OrderReports'][0]['ReportAddresses'][0]['AddressType'] = $addressType;

//        $order['OrderReports'][0]['ReportAddresses'][0]['Latitude']    = 0;
//        $order['OrderReports'][0]['ReportAddresses'][0]['Longitude']   = 0;
//        $order['OrderReports'][0]['ReportAddresses'][0]['AddressType'] = 1;
        //@formatter:on


//        pd($order,'$order');
        $this->_order = $order;
    }

    public function orderReport(){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $this->_headers['Content-Type'] = "application/JSON";
        $uri = 'v2/Order/PlaceOrder';

        $this->_debug = false;

        $this->response = $this->makeRequest('POST' ,$uri , 'body' ,json_encode($this->_order));

//        pd( $this->response,' $this->response');

        if($this->response['code'] == 200){
        }

        return $this->response;
    }

    public function getReport($reportId){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $this->_headers['Content-Type'] = "application/JSON";
        $uri = 'v3/Report/GetReport?reportId='.$reportId;

        $this->_debug = false;

        $this->response = $this->makeRequest('GET', $uri,'params',['reportId' => $reportId]);

//        pd( $this->response,' $this->response');

        if($this->response['code'] == 200){
        }

        return $this->response;
    }

    public function parseProducts()
    {
        $eProducts = [];
        pd($this->response['data'], '$this->response[\'data\']');
        foreach ($this->response['data'] AS $key => $item) {

            //@formatter:off
            $eProducts[$key] = [
                'productID'        => $item['productID'],
                'name'             => $item['name'],
                'deliveryProducts' => $item['deliveryProducts'],
                'addOnProducts'    => $item['addOnProducts']
            ];
            //@formatter:on
        }
        return $eProducts;
    }

    public function getSpecFields(){
        /*Roofing Specs
        Gutter Specs
        Siding Specs
        Garage Door Specs
        Insulation Specs*/
        $specs = 'Roofing Specs,Gutter Specs';
        $uri = $this->_accessToken . '/fields/'.$specs;
        $this->response = $this->makeRequest('GET' ,$uri , []);

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function createProject(){

        $specs = 'build_specs';
        $uri = 'build_specs';

        $build_specs['type'] = 'roofing|siding|gutter';
        $build_specs['Siding Type'] = '1234';
        $build_specs['Siding Sqft'] = '1234';

        $build_specs['Ridge Type'] = '5478';
        $build_specs['B-Elbows'] = '5478';

        $payload['access_token'] = $this->_accessToken;
        $employee_id = '857e3102-792f-42e1-960b-3a0a041fd775';

        $payload['project_id'] = '857e3102-792f-11111';
        $payload['employee_id'] = $employee_id;
        $payload['build_specs'] = $build_specs;

        $this->response = $this->makeRequest1('POST' ,$uri , $payload);
        print_r($this->response);
        exit;

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function getEmployee($email_address){

        $uri = $this->_accessToken . '/employee/'.$email_address;
//        Helper::pd($uri,'getEmployee > $uri');

        $this->response = $this->makeRequest('GET' ,$uri , []);

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function getEmployeeProject($employee_id){

        $uri = $this->_accessToken . '/project/for/'.$employee_id;

        $this->response = $this->makeRequest('GET' ,$uri , []);
        //print_r($this->response);
        //exit;

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function getSpecs($specType = ""){
        $uri = !empty($specType) ? $this->_accessToken . '/fields/' . $specType : $this->_accessToken . '/fields';

        $this->response = $this->makeRequest('GET' ,$uri , []);
//        print_r($this->response);
//        exit;

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function addProject($projects)
    {
        $projectUri = 'build_specs/';
        $mediaUri = 'image/new/';
        $this->_headers['Content-Type'] = 'application/json;charset=UTF-8';
        unset($this->_headers['Authorization']);

        $projectIdResponse = [];
        foreach ($projects AS $pKey => $pItem) {
            $projectRequest['access_token'] = $this->_accessToken;
            $projectRequest['project_id'] = $pItem['project_id'];
            $projectRequest['employee_id'] = $pItem['employee_id'];
            $projectRequest['build_specs'] = $pItem['build_spec'];

            if(empty($pItem['build_spec'])){
                $projectIdResponse['error'][$pKey]['id'] = $pItem['id'];
                $projectIdResponse['error'][$pKey]['error'] = $pItem['error'];
                continue;
            }

            $mediaRequest['access_token'] = $this->_accessToken;
            $mediaRequest['project_id'] = $pItem['project_id'];
            $mediaRequest['employee_id'] = $pItem['employee_id'];
            $mediaRequest['images'] = $pItem['images'];

            $projectResponse = $this->makeRequest('post' ,$projectUri , $this->_payloadType['raw'], json_encode($projectRequest));

            $mediaResponse = $this->makeRequest('post' ,$mediaUri , $this->_payloadType['raw'], json_encode($mediaRequest));

            if ($mediaResponse['code'] == 200) {
                if ($projectResponse['code'] == 200) {
//                    echo "<br> Media Added Project Added";
                    $projectIdResponse['success'][$pKey]['id'] = $pItem['id'];
                } else {
//                    echo "<br> Media Added Project Failed";
                }
            } else {
                /*TODO: Log Error Some where */
//                echo "<br> Media Failed";
            }
        } /*End foreach*/

//        pd($projectIdResponse,'$projectIdResponse');
        return $projectIdResponse;
    }

    public function addMedia($media){

//        die($this->_accessToken);
        ;

        $media['access_token'] = $this->_accessToken;
//        die($this->_headers['Content-Type']);
        $this->_headers['Content-Type'] = 'application/json';
        unset($this->_headers['Authorization']);
//        Helper::pd($project,'json_encode($project)');
//        Helper::pd(json_encode($project),'$payload');
//        Helper::pd($this->_payloadType,'');
        $this->response = $this->makeRequest('POST' ,$uri , $this->_payloadType['raw'], $media);
        //print_r($this->response);
        //exit;

        if($this->response['code'] == 200){
            return true;
        }
    }

    public function cUrlGetData($url, $post_fields = null, $headers = null) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }
}