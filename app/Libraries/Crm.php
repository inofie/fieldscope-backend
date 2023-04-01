<?php
/**
 * Created by PhpStorm.
 * User: developer_retrocube
 * Date: 8/8/2019
 * Time: 10:42 AM
 */

namespace App\Libraries;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class Crm
{
    protected $_baseUrl, $_debug, $_accessToken, $_refreshToken, $_tokenType, $_accessTokenExpiresAt, $response, $_company;

    protected $_payloadType = [
        'raw' => 'body',
        'params' => 'params',
        'form_data' => 'form_params',
        'multipart' => 'multipart'
    ];
    public $_headers = [
//        'Content-Type' => 'application/x-www-form-urlencoded',
    ];

    public $_fileResource = NULL;


    public function __construct($company)
    {
        $this->response = [
            'code'    => 200, //status code
            'data' => [] ,//data
            'message' => ''
        ];

        $this->_company = $company;
    }

    /**
     * @return mixed
     */
    public function getCompleteResponse()
    {
        return $this->response;
    }

    protected function makeRequest($method, $url , $payloadType = '' ,$payload = []){
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

            if($this->_fileResource)
            $requestOptions['sink'] = $this->_fileResource;

            if($this->_debug)
            $requestOptions['debug'] = $this->_debug;

            if($this->_debug){
                $requestOptions['debug'] = true;
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
            $this->response['code']    = $e->getResponse()->getStatusCode(); # 400
            $this->response['headers'] = $e->getRequest()->getHeaders(); # 'application/json; charset=utf8'
            $this->response['message'] = $e->getMessage();
            $this->response['content'] = $e->getRequest()->getBody()->getContents();

            if($this->_debug){
                $catch = [
                    'code' => $e->getResponse()->getStatusCode(),
                    'headers' => $e->getRequest()->getHeaders(),
                    'message' => $e->getMessage(),
                    'content' => $e->getRequest()->getBody()->getContents(),
                ];
                p($catch,'$catch');

                /*p($e->getResponse()->getStatusCode(),'Catch: $e->getResponse()->getStatusCode()');
                p($e->getRequest()->getHeaders(),'Catch: $e->getRequest()->getHeaders()');
                p($e->getRequest()->getBody()->getContents(),'Catch: $e->getRequest()->getBody()->getContents()');*/
            }

            Log::error("makeRequest() - Exception - Message:".$e->getMessage()." @".$url,$e->getRequest()->getHeaders());

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

            if( !empty($requestOptions['sink']) AND  !empty($this->_fileResource)){
                $this->response['data'] = $this->_fileResource;
            }else{
                $this->response['data']        = json_decode($response->getBody()->getContents(),TRUE); # '{"id": 1420053, "name": "guzzle", ...}'
            }

            if($this->_fileResource)
                $requestOptions['sink'] = $this->_fileResource;

            Log::info("makeRequest() - @".$url,$response->getHeaders());

            if($this->_debug){
                p($this->response,'$this->response');
            }
            return $this->response;
        } else {
            Log::error("makeRequest() - Response Empty");
            return $this->response;
        }
    }

    protected function getAccessToken()
    {
        return $this->_accessToken;
    }

}