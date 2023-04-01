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


class JobScope
{
    private $_response,$_baseUrl,$_debug;

    public $_accessToken, $_accessTokenExpiresAt, $response;
    public $_payloadType = [
        'raw' => 'body',
        'form_data' => 'form_params'
    ];
    public $_headers = [
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Authorization' => 'Basic ODdhNDUzYWEtOWQwOS00MzFjLThmMWMtNmI2MjQ5MDlmZTQ5OmZjY2UyMWNhYTE=',

        'ClientId' => '87a453aa-9d09-431c-8f1c-6b624909fe49',
        'Init-token' => 'fcce21caa1'
    ];

    public function __construct()
    {
        $this->response = [
            'code'    => 200, //status code
            'data' => [] ,//data
            'message' => ''
        ];

        $this->_baseUrl = 'http://jobscope.chesapeaketg.com/api/v1/';


        $this->_debug = true;
//        fopen('php://stderr', 'w')

        $this->authenticate();
    }

    public function makeRequest($method, $url , $payloadType = '' ,$payload = []){
        $client = new \GuzzleHttp\Client();
        //$response = new \stdClass();
        $exception = NULL;
        try {

//            Helper::p($this->_baseUrl . $url,'MAKE Req:  Request URL: ');
//            Helper::p([
//                'form_params' => $payload,
//                'headers' => $this->_headers
//            ],'MAKE Req: PARAM' );


            $payloadType = !empty($payloadType) ? $payloadType : $this->_payloadType['form_data'];

            $requestOptions = [
//                'debug' => true,
                'headers' => $this->_headers,
                $payloadType => $payload
            ];

            $response = $client->request(
                $method, /*METHOD */
                $this->_baseUrl . $url, /*URL*/
                $requestOptions
            );

        } catch (RequestException $e) {
            $this->response['code'] = 400; # 400
            $this->response['headers'] = $e->getRequest()->getHeaders(); # 'application/json; charset=utf8'

            Log::error("app/Libraries/Crm.php/makeRequest() - Exception - ".$e->getMessage()." @".$url,$e->getRequest()->getHeaders());

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
//            pd($response->getHeaders(),'$response');
            Log::info("app/Libraries/Crm.php/makeRequest() - @".$url,$response->getHeaders());


            return $this->response;
        } else {
            Log::error("app/Libraries/Crm.php/makeRequest() - Response Empty");
            return $this->response;
        }


    }


    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function authenticate(){
        $crmModel = CrmModel::find(1);
//        Helper::pd($crmModel->toArray(),'$crmModel');

        $expiresAt = new Carbon($crmModel->expires_at);
        $today = Carbon::now();


        if($today->lt($expiresAt)){
//            Helper::pd([],'Use Existing');
            $payload['request_type']= 'renew';
        }else{
//            Helper::pd([],'Make NEW');
            $payload['request_type']= 'initial';
        }

        /*Making Login Request*/
        $payload['username']    = 'fieldscope@emerson-enterprises.com';
        $payload['password']    = 'password';
        $this->response = $this->makeRequest('POST' ,'token' ,'', $payload);

        /*Updating new tokens in DB*/
        $crmModel->access_token = $this->response['data']['access_token'];
        $crmModel->expires_at = $this->response['data']['expires'];
        $crmModel->save();

        $this->_accessToken             = $crmModel->access_token;
        $this->_accessTokenExpiresAt    = $crmModel->expires_at;

//        Helper::pd($crmModel->toArray(),'$crmModel');
//        var_dump($crmModel->access_token);
        return $this->response;
    }

    public function getProjectDetail(){
        $project_id = 'd64c5a6f-e211-4922-aabf-deb869450193';
        $uri = $this->_accessToken . '/project/'.$project_id;
        $this->response = $this->makeRequest('GET' ,$uri , []);
        if($this->response['code'] == 200){
            return true;
        }
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