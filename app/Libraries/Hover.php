<?php
/**
 * Created by PhpStorm.
 * User: developer_retrocube
 * Date: 8/8/2019
 * Time: 10:42 AM
 */

namespace App\Libraries;
use App\Models\CrmModel;
use App\Models\HoverField;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class Hover extends Crm
{

    //    private $_response,$_baseUrl,$_debug;
//    public $_accessToken,$_refreshToken,$_tokenType, $_accessTokenExpiresAt, $response,$_company;
//    public $_payloadType = [
//        'raw' => 'body',
//        'params' => 'params',
//        'form_data' => 'form_params',
//        'multipart' => 'multipart'
//    ];
//    public $_headers = [
////        'Content-Type' => 'application/x-www-form-urlencoded',
//    ];

    private $environment,$job,$fieldTypes;


    public function __construct($company)
    {
        parent::__construct($company);

        $this->_baseUrl = env('HOVER_BASE_URL','https://sandbox.hover.to/api/');
        $this->_debug = false;
        $this->job = null;
        $this->environment = env('HOVER_ENV','sandbox');

        $this->fieldTypes = [
            'roof','front','back','left','right'
        ];




        $this->authenticate();
    }

    public function authenticate(){

        $crmModel = CrmModel::firstOrNew(['identifier' => 'hover', 'company_id' => $this->_company['id']]);

        if($this->_debug AND $crmModel) {
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
            $payload['grant_type'] = 'authorization_code';
            $payload['code'] = $this->_company['hover_auth_code'];
            $payload['client_id'] = $this->_company['hover_client_id'];
            $payload['client_secret'] = $this->_company['hover_client_secret'];
            $payload['redirect_uri'] = url('hover/authentication/'.$this->_company['hover_ref_code']);

//            pd($payload,'$payload');

            /** Making Login Request*/
            $this->response = $this->makeRequest('POST' ,'oauth/token' ,'form_params', $payload);

        }
        else if(now()->gt($expiresAt)){

            if($this->_debug) echo "<br>Refresh Token";

            /** Refresh Token */
            $payload['grant_type']= 'refresh_token';
            $payload['refresh_token']= $crmModel->refresh_token;
            $payload['client_id']= $this->_company['hover_client_id'];
            $payload['client_secret']= $this->_company['hover_client_secret'];


            /** Making Login Request*/
            $this->response = $this->makeRequest('POST' ,'oauth/token' ,'form_params', $payload);

            if ($this->response['code'] != 200) {
                if ($this->_debug) echo "<br>New Token 2";
                /** New Token */
                $payload['grant_type'] = 'authorization_code';
                $payload['code'] = $this->_company['hover_auth_code'];
                $payload['client_id'] = $this->_company['hover_client_id'];
                $payload['client_secret'] = $this->_company['hover_client_secret'];
                $payload['redirect_uri'] = url('hover/authentication/' . $this->_company['hover_ref_code']);

//                pd($payload, '$payload');

                /** Making Login Request*/
                $this->response = $this->makeRequest('POST', 'oauth/token', 'form_params', $payload);
            }
        }else{
            if($this->_debug) echo "<br> Auth not expired, using it...";
        }

        /** Creating/Updating new tokens in DB*/
        if(!empty($this->response['data'])){
            $crmModel->access_token     = $this->response['data']['access_token'];
            $crmModel->refresh_token    = $this->response['data']['refresh_token'];
            $crmModel->token_type       = $this->response['data']['token_type'];
            $crmModel->expires_at       = now()->addSeconds($this->response['data']['expires_in'])->format('Y-m-d H:i:s');
            $crmModel->save();
        }

//        p($this->response['message'],'authenticate > $this->response[\'message\']');
//        pd($this->response['data'],'authenticate > $this->response[\'data\']');

        $this->_accessToken             = $crmModel->access_token;
        $this->_refreshToken            = $crmModel->refresh_token;
        $this->_tokenType               = $crmModel->token_type;
        $this->_accessTokenExpiresAt    = $crmModel->expires_at;

        return $this->response;
    }

    public function createJob($request){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;

        $payload = [];

        $payload['job']['customer_name'] = $request['customer_name'];
        $payload['job']['customer_email'] = $request['customer_email'];
        $payload['job']['name'] = $request['name'];
        $payload['job']['location_line_1'] = $request['location_line_1'];
        $payload['job']['location_city'] = $request['location_city'];
        $payload['job']['location_region'] = $request['location_region'];
        $payload['job']['location_postal_code'] = $request['location_postal_code'];
        $payload['job']['location_country'] = $request['location_country'];
        $payload['current_user_email'] = $request['current_user_email'];

        Log::info("createJob() > payload ".json_encode($payload));
        $createJobResponse = $this->makeRequest('POST' ,'v1/jobs' ,'form_params', $payload);

        $this->response = $createJobResponse ;
        return $this->response['data'];
    }

    public function updateTestJob($jobId,$state,$userEmail){
        $allowedStates = ["complete", "failed"];
        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $this->_headers['Content-Type'] = "application/x-www-form-urlencoded";
        $this->_headers['Cookie'] = "_ga=GA1.2.2051865578.1610032771; ajs_anonymous_id=%2280d0af56-25a4-43ee-87bd-31c72a70e2b8%22; FPID=FPID1.2.9m4HBM9Bx%2F4O8Rbmd7rWRmOTgQGienQKxAuMBd11VRo%3D.1610032771; __stripe_mid=0794d0e6-3938-47ec-96bb-730b57875d270aaf2f; _gcl_au=1.1.1641935180.1619463489; _fbp=fb.1.1619464593017.1574890450; ajs_user_id=%22paul%40emerson-enterprises.com%22; ab.storage.deviceId.dd4574f7-852a-4038-9e0e-d8381e03548a=%7B%22g%22%3A%2213ea8f17-5eab-1d05-887b-4d8abed0bcd0%22%2C%22c%22%3A1610032773073%2C%22l%22%3A1619464651052%7D; ab.storage.userId.dd4574f7-852a-4038-9e0e-d8381e03548a=%7B%22g%22%3A%22paul%40emerson-enterprises.com%22%2C%22c%22%3A1619464651047%2C%22l%22%3A1619464651053%7D; _hyperion_session_sandbox=444e16bbb11d2fff0916a9121fd75ae4; mp_2892de77f399d73ec552020e0d1c35e7_mixpanel=%7B%22distinct_id%22%3A%20%22paul%40emerson-enterprises.com%22%2C%22%24device_id%22%3A%20%22176dd6e7795604-0249bf3b1ae061-5b68362c-1fa400-176dd6e779656e%22%2C%22%24initial_referrer%22%3A%20%22%24direct%22%2C%22%24initial_referring_domain%22%3A%20%22%24direct%22%2C%22user_id%22%3A%20647%2C%22user_email%22%3A%20%22paul%40emerson-enterprises.com%22%2C%22user_is_test_data%22%3A%20false%2C%22org_id%22%3A%20558%2C%22org_name%22%3A%20%22Emerson%20Enterprises%20Unlimited%20LLC%22%2C%22partner_id%22%3A%201%2C%22partner_name%22%3A%20%22Hover%22%2C%22%24user_id%22%3A%20%22paul%40emerson-enterprises.com%22%7D; _uetvid=5ae73160c84c11eb955105868d3f09b4; ab.storage.sessionId.dd4574f7-852a-4038-9e0e-d8381e03548a=%7B%22g%22%3A%2252ae08ee-8ceb-fb7c-d1ec-f41f08d95cab%22%2C%22e%22%3A1623153446905%2C%22c%22%3A1623151581482%2C%22l%22%3A1623151646905%7D";

        /** Auto complete the job in sandbox mode*/
        if($this->environment == 'sandbox'){
            $params['state'] = $state?: 'complete';
            if(!empty($params['state'])){
                if(in_array($state,$allowedStates)){
                    $queryString  = "state={$params['state']}&current_user_email={$userEmail}";
                    // api/v2/jobs/{{job_id}}/set_test_state.json?state=failed
                    $this->makeRequest('PATCH' ,"v2/jobs/$jobId/set_test_state.json?".$queryString );
                    Log::info("Hover Log: @updateTestJob - ".json_encode(['code' => $this->response['code'], 'job_id' => $jobId , 'state'=> $state]));
                }
            }
        }
        return $this->response['data'];
    }

    public function getFullMeasurements($jobId,$extension="json",$version = NULL){
        $allowedVersions = ["full_json", "failed"];
        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;

//        $this->updateTestJob($jobId,'complete');

        if(!empty($version) AND in_array($version,$allowedVersions)){
            // {{url}}/api/
            $qString = "version=$version";
        }else{
            $pathToFile =  base_path("public/uploads/hover/".$jobId.".pdf");
            $this->_fileResource = $pathToFile;
        }

        $this->response = $this->makeRequest('GET' ,"v2/jobs/$jobId/measurements.$extension?$qString" ,'');

        $this->job = $this->response['data'];
        return $this->response['data'];
    }

    public function listUsers($params = null){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $this->_headers['Content-Type'] = 'application/x-www-form-urlencoded';
//        $this->_headers['Content-Type'] = 'multipart/form-data';
//        $this->_headers['Content-Type'] = 'application/json';

        $payload = [];

        $payload['email'] = $params['email'] ?: NULL;
        $payload['name'] = $params['first_name'] ?: NULL;

        $payload = array_filter($payload);

        $this->response = $this->makeRequest('GET' ,'v2/users' ,'form_params', $payload);
        return $this->response['data'];
        p($this->response['message'],'$this->response[\'message\']');
        pd($this->response['data'],'$this->response[\'data\']');
    }

    /** Isn't using currently anywhere*/
    public function creatWebhook(){

        $this->_headers['Authorization'] = $this->_tokenType.' '.$this->_accessToken;
        $this->_headers['Content-Type'] = 'application/x-www-form-urlencoded';
//        $this->_headers['Content-Type'] = 'multipart/form-data';
//        $this->_headers['Content-Type'] = 'application/json';

        $payload = [];

//        $payload['webhook']['url'] = "daniel";

        $payload['current_user_email'] = "kyle.brazil+postman@hover.to";
//        $payload[] = [
//            'name' => 'current_user_email',
//            'contents' => 'kyle.brazil+postman@hover.to'
//        ];
//        $payload['current_user_id'] = 143;

        // https://hover.to/api/
        $this->response = $this->makeRequest('POST' ,'v2/webhooks' ,'form_params', []);

        p($this->response['message'],'$this->response[\'message\']');
        pd($this->response['data'],'$this->response[\'data\']');
    }

    //<editor-fold desc="Job Json Template">
    public $sampleJob = '{
  "version": 1,
  "summary": {
    "area": {
      "facades": {
        "siding": 2386,
        "other": 223
      },
      "openings": {
        "siding": 243,
        "other": 30
      },
      "unknown": {
        "siding": null,
        "other": 0
      },
      "total": {
        "siding": 2629,
        "other": 253
      }
    },
    "openings": {
      "quantity": {
        "siding": 16,
        "other": 2
      },
      "tops_length": {
        "siding": 46.92,
        "other": 5.83
      },
      "sills_length": {
        "siding": 45.92,
        "other": 5.83
      },
      "sides_length": {
        "siding": 140.75,
        "other": 20.17
      },
      "total_perimeter": {
        "siding": 233.58,
        "other": 31.92
      }
    },
    "siding_waste": {
      "zero": 2386,
      "plus_10_percent": 2625,
      "plus_18_percent": 2815,
      "with_openings": 2596,
      "openings_plus_10_percent": 2855,
      "openings_plus_18_percent": 3063
    },
    "trim": {
      "level_starter": {
        "siding": 180.5,
        "other": 17.67
      },
      "sloped_trim": {
        "siding": 35,
        "other": 0
      },
      "vertical_trim": {
        "siding": 65.08,
        "other": 82.83
      }
    },
    "roofline": {
      "eaves_fascia": {
        "length": 137.83,
        "avg_depth": null,
        "soffit_area": null
      },
      "level_frieze_board": {
        "length": 118.08,
        "avg_depth": 1.17,
        "soffit_area": 182
      },
      "rakes_fascia": {
        "length": 146,
        "avg_depth": null,
        "soffit_area": null
      },
      "sloped_frieze_board": {
        "length": 126.08,
        "avg_depth": 0.75,
        "soffit_area": 52
      }
    },
    "corners": {
      "inside_corners_qty": {
        "siding": 6,
        "other": null
      },
      "inside_corners_len": {
        "siding": 38.83,
        "other": null
      },
      "outside_corners_qty": {
        "siding": 6,
        "other": null
      },
      "outside_corners_len": {
        "siding": 58.83,
        "other": null
      }
    },
    "accessories": {
      "shutter_qty": {
        "siding": 4,
        "other": 4
      },
      "shutter_area": {
        "siding": 21,
        "other": 25
      },
      "vents_qty": {
        "siding": 0,
        "other": 0
      },
      "vents_area": {
        "siding": 0,
        "other": 0
      }
    },
    "roof": {
      "roof_facets": {
        "area": 2139,
        "total": 11,
        "length": null
      },
      "ridges_hips": {
        "area": null,
        "total": 5,
        "length": 87.17
      },
      "valleys": {
        "area": null,
        "total": 5,
        "length": 56.92
      },
      "rakes": {
        "area": null,
        "total": 16,
        "length": 146
      },
      "gutters_eaves": {
        "area": null,
        "total": 11,
        "length": 137.83
      },
      "flashing": {
        "area": null,
        "total": 9,
        "length": 33.67
      },
      "step_flashing": {
        "area": null,
        "total": 10,
        "length": 35.83
      },
      "pitch": [
        {
          "roof_pitch": "7/12",
          "area": 1026,
          "percentage": 47.98
        },
        {
          "roof_pitch": "8/12",
          "area": 629,
          "percentage": 29.4
        },
        {
          "roof_pitch": "4/12",
          "area": 405,
          "percentage": 18.95
        },
        {
          "roof_pitch": "6/12",
          "area": 68,
          "percentage": 3.17
        }
      ],
      "waste_factor": {
        "area": {
          "zero": 2139,
          "plus_5_percent": 2246,
          "plus_10_percent": 2353,
          "plus_15_percent": 2460,
          "plus_20_percent": 2567
        }
      }
    },
    "address": "532 NE Cumberland Dr, Blue Springs, MO 64014, Blue Springs, Missouri 90021",
    "property_id": 20839,
    "external_identifier": ""
  },
  "footprint": {
    "stories": ">1",
    "perimeter": 201.17,
    "area": 1622,
    "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_footprint.png"
  },
  "elevations": {
    "sides": {
      "front": {
        "total": 234,
        "area_per_label": [
          {
            "SI-1": 95
          },
          {
            "SI-2": 71
          },
          {
            "SI-4": 36
          },
          {
            "SI-5": 32
          }
        ]
      },
      "right": {
        "total": 803,
        "area_per_label": [
          {
            "SI-3": 252
          },
          {
            "SI-6": 3
          },
          {
            "SI-7": 548
          }
        ]
      },
      "left": {
        "total": 769,
        "area_per_label": [
          {
            "SI-10": 21
          },
          {
            "SI-11": 16
          },
          {
            "SI-12": 508
          },
          {
            "SI-13": 11
          },
          {
            "SI-14": 213
          }
        ]
      },
      "back": {
        "total": 580,
        "area_per_label": [
          {
            "SI-8": 529
          },
          {
            "SI-9": 51
          }
        ]
      }
    }
  },
  "facades": {
    "siding": [
      {
        "facade": "SI-1",
        "area": 95,
        "shutters": 2,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 95,
          "plus_10_percent": 105,
          "plus_18_percent": 112,
          "with_openings": 111,
          "openings_plus_10_percent": 122,
          "openings_plus_18_percent": 131
        },
        "trim": {   
        "level_starter": 12.25,
          "sloped": 6.92,
          "vertical": 6.5
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 5.58,
          "outside_number": 1,
          "outside_length": 5.42
        },
        "roofline": {
          "level_frieze_board": 1.33,
          "sloped_frieze_board": 18.08
        },
        "openings": {
          "tops": 3.33,
          "sills": 3.33,
          "sides": 9.08,
          "openings_total": 1
        }
      },
      {
        "facade": "SI-2",
        "area": 71,
        "shutters": 2,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 71,
          "plus_10_percent": 78,
          "plus_18_percent": 84,
          "with_openings": 86,
          "openings_plus_10_percent": 95,
          "openings_plus_18_percent": 101
        },
        "trim": {
          "level_starter": 9.92,
          "sloped": 0,
          "vertical": 1.67
        },
        "corners": {
          "inside_number": 0,
          "inside_length": 0,
          "outside_number": 2,
          "outside_length": 12.5
        },
        "roofline": {
          "level_frieze_board": 0,
          "sloped_frieze_board": 11.92
        },
        "openings": {
          "tops": 2.92,
          "sills": 2.92,
          "sides": 9.08,
          "openings_total": 1
        }
      },
      {
        "facade": "SI-3",
        "area": 252,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 252,
          "plus_10_percent": 277,
          "plus_18_percent": 297,
          "with_openings": 252,
          "openings_plus_10_percent": 277,
          "openings_plus_18_percent": 297
        },
        "trim": {
          "level_starter": 18.42,
          "sloped": 6.83,
          "vertical": 9.92
        },
        "corners": {
          "inside_number": 2,
          "inside_length": 12.83,
          "outside_number": 1,
          "outside_length": 6.25
        },
        "roofline": {
          "level_frieze_board": 18.33,
          "sloped_frieze_board": 5.42
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-4",
        "area": 36,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 36,
          "plus_10_percent": 40,
          "plus_18_percent": 42,
          "with_openings": 56,
          "openings_plus_10_percent": 62,
          "openings_plus_18_percent": 66
        },
        "trim": {
          "level_starter": 9.5,
          "sloped": 0,
          "vertical": 0
        },
        "corners": {
          "inside_number": 2,
          "inside_length": 15.42,
          "outside_number": 0,
          "outside_length": 0
        },
        "roofline": {
          "level_frieze_board": 9.5,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 4.92,
          "sills": 4.92,
          "sides": 14.92,
          "openings_total": 1
        }
      },
      {
        "facade": "SI-5",
        "area": 32,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 32,
          "plus_10_percent": 35,
          "plus_18_percent": 38,
          "with_openings": 44,
          "openings_plus_10_percent": 48,
          "openings_plus_18_percent": 52
        },
        "trim": {
          "level_starter": 9.5,
          "sloped": 0,
          "vertical": 0
        },
        "corners": {
          "inside_number": 2,
          "inside_length": 10.25,
          "outside_number": 0,
          "outside_length": 0
        },
        "roofline": {
          "level_frieze_board": 4.5,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 0,
          "sills": 5,
          "sides": 13.67,
          "openings_total": 2
        }
      },
      {
        "facade": "SI-6",
        "area": 3,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 3,
          "plus_10_percent": 3,
          "plus_18_percent": 4,
          "with_openings": 3,
          "openings_plus_10_percent": 3,
          "openings_plus_18_percent": 4
        },
        "trim": {
          "level_starter": 2.08,
          "sloped": 0,
          "vertical": 2.58
        },
        "corners": {
          "inside_number": 0,
          "inside_length": 0,
          "outside_number": 0,
          "outside_length": 0
        },
        "roofline": {
          "level_frieze_board": 0,
          "sloped_frieze_board": 2.33
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-7",
        "area": 548,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 548,
          "plus_10_percent": 603,
          "plus_18_percent": 647,
          "with_openings": 548,
          "openings_plus_10_percent": 603,
          "openings_plus_18_percent": 647
        },
        "trim": {
          "level_starter": 28.33,
          "sloped": 0,
          "vertical": 18.67
        },
        "corners": {
          "inside_number": 0,
          "inside_length": 0,
          "outside_number": 1,
          "outside_length": 16.67
        },
        "roofline": {
          "level_frieze_board": 5.08,
          "sloped_frieze_board": 27.08
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-8",
        "area": 529,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 529,
          "plus_10_percent": 582,
          "plus_18_percent": 624,
          "with_openings": 634,
          "openings_plus_10_percent": 697,
          "openings_plus_18_percent": 748
        },
        "trim": {
          "level_starter": 34.58,
          "sloped": 0,
          "vertical": 0
        },
        "corners": {
          "inside_number": 0,
          "inside_length": 0,
          "outside_number": 2,
          "outside_length": 33.33
        },
        "roofline": {
          "level_frieze_board": 40.58,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 26.75,
          "sills": 20.75,
          "sides": 64.25,
          "openings_total": 8
        }
      },
      {
        "facade": "SI-9",
        "area": 51,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 51,
          "plus_10_percent": 56,
          "plus_18_percent": 60,
          "with_openings": 69,
          "openings_plus_10_percent": 76,
          "openings_plus_18_percent": 81
        },
        "trim": {
          "level_starter": 9.75,
          "sloped": 0,
          "vertical": 0
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 7.58,
          "outside_number": 1,
          "outside_length": 7.58
        },
        "roofline": {
          "level_frieze_board": 9.75,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 3.33,
          "sills": 3.33,
          "sides": 14.08,
          "openings_total": 1
        }
      },
      {
        "facade": "SI-10",
        "area": 21,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 21,
          "plus_10_percent": 23,
          "plus_18_percent": 25,
          "with_openings": 21,
          "openings_plus_10_percent": 23,
          "openings_plus_18_percent": 25
        },
        "trim": {
          "level_starter": 2.75,
          "sloped": 0,
          "vertical": 7.75
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 7.75,
          "outside_number": 0,
          "outside_length": 0
        },
        "roofline": {
          "level_frieze_board": 2.75,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-11",
        "area": 16,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 16,
          "plus_10_percent": 18,
          "plus_18_percent": 19,
          "with_openings": 16,
          "openings_plus_10_percent": 18,
          "openings_plus_18_percent": 19
        },
        "trim": {
          "level_starter": 0,
          "sloped": 3.08,
          "vertical": 6.58
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 5.17,
          "outside_number": 0,
          "outside_length": 0
        },
        "roofline": {
          "level_frieze_board": 2.75,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-12",
        "area": 508,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 508,
          "plus_10_percent": 559,
          "plus_18_percent": 599,
          "with_openings": 532,
          "openings_plus_10_percent": 585,
          "openings_plus_18_percent": 628
        },
        "trim": {
          "level_starter": 21.83,
          "sloped": 16.17,
          "vertical": 2.75
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 7.58,
          "outside_number": 2,
          "outside_length": 22.08
        },
        "roofline": {
          "level_frieze_board": 13.67,
          "sloped_frieze_board": 27.33
        },
        "openings": {
          "tops": 5.67,
          "sills": 5.67,
          "sides": 15.58,
          "openings_total": 2
        }
      },
      {
        "facade": "SI-13",
        "area": 11,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 11,
          "plus_10_percent": 12,
          "plus_18_percent": 13,
          "with_openings": 11,
          "openings_plus_10_percent": 12,
          "openings_plus_18_percent": 13
        },
        "trim": {
          "level_starter": 0,
          "sloped": 1.92,
          "vertical": 0
        },
        "corners": {
          "inside_number": 1,
          "inside_length": 5.58,
          "outside_number": 1,
          "outside_length": 6.25
        },
        "roofline": {
          "level_frieze_board": 1.83,
          "sloped_frieze_board": 0
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      },
      {
        "facade": "SI-14",
        "area": 213,
        "shutters": 0,
        "vents": 0,
        "area_with_waste_factor_calculation": {
          "zero": 213,
          "plus_10_percent": 234,
          "plus_18_percent": 251,
          "with_openings": 213,
          "openings_plus_10_percent": 234,
          "openings_plus_18_percent": 251
        },
        "trim": {
          "level_starter": 21.58,
          "sloped": 0,
          "vertical": 8.75
        },
        "corners": {
          "inside_number": 0,
          "inside_length": 0,
          "outside_number": 1,
          "outside_length": 7.58
        },
        "roofline": {
          "level_frieze_board": 0.75,
          "sloped_frieze_board": 22
        },
        "openings": {
          "tops": 0,
          "sills": 0,
          "sides": 0,
          "openings_total": 0
        }
      }
    ],
    "brick": [
      {
        "facade": "BR-1",
        "area": 12,
        "shutters": 0,
        "vents": 0,
        "openings": {
          "openings_total": 0
        }
      },
      {
        "facade": "BR-2",
        "area": 18,
        "shutters": 0,
        "vents": 0,
        "openings": {
          "openings_total": 0
        }
      },
      {
        "facade": "BR-3",
        "area": 17,
        "shutters": 0,
        "vents": 0,
        "openings": {
          "openings_total": 0
        }
      },
      {
        "facade": "BR-4",
        "area": 176,
        "shutters": 4,
        "vents": 0,
        "openings": {
          "openings_total": 2
        }
      }
    ]
  },
  "openings": {
    "windows": [
      {
        "opening": "W-1",
        "width_x_height": "41\" x 56\"",
        "united_inches": "97\"",
        "area": 16
      },
      {
        "opening": "W-2",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-3",
        "width_x_height": "24\" x 36\"",
        "united_inches": "60\"",
        "area": 6
      },
      {
        "opening": "W-4",
        "width_x_height": "24\" x 36\"",
        "united_inches": "60\"",
        "area": 6
      },
      {
        "opening": "W-5",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-6",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-7",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-8",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-9",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-10",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-11",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-12",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-13",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      },
      {
        "opening": "W-14",
        "width_x_height": "35\" x 35\"",
        "united_inches": "70\"",
        "area": 9
      },
      {
        "opening": "W-15",
        "width_x_height": "36\" x 60\"",
        "united_inches": "96\"",
        "area": 15
      }
    ],
    "doors": [
      {
        "opening": "D-1",
        "width_x_height": "96\" x 84\"",
        "area": 56
      },
      {
        "opening": "D-2",
        "width_x_height": "192\" x 84\"",
        "area": 112
      },
      {
        "opening": "D-3",
        "width_x_height": "36\" x 80\"",
        "area": 20
      },
      {
        "opening": "D-4",
        "width_x_height": "32\" x 80\"",
        "area": 18
      },
      {
        "opening": "D-5",
        "width_x_height": "60\" x 80\"",
        "area": 33
      }
    ]
  },
  "roof": {
    "measurements": {
      "ridges": 87.17,
      "hips": 0,
      "valleys": 56.92,
      "rakes": 146,
      "gutters_eaves": 137.83,
      "flashing": 33.67,
      "step_flashing": 35.83
    },
    "facets": [
      {
        "facet": "RF-11",
        "area": 617,
        "pitch": 7
      },
      {
        "facet": "RF-1",
        "area": 279,
        "pitch": 4
      },
      {
        "facet": "RF-8",
        "area": 409,
        "pitch": 7
      },
      {
        "facet": "RF-4",
        "area": 258,
        "pitch": 8
      },
      {
        "facet": "RF-10",
        "area": 50,
        "pitch": 8
      },
      {
        "facet": "RF-2",
        "area": 68,
        "pitch": 6
      },
      {
        "facet": "RF-5",
        "area": 127,
        "pitch": 4
      },
      {
        "facet": "RF-9",
        "area": 48,
        "pitch": 8
      },
      {
        "facet": "RF-6",
        "area": 249,
        "pitch": 8
      },
      {
        "facet": "RF-3",
        "area": 24,
        "pitch": 8
      },
      {
        "facet": "RF-7",
        "area": 11,
        "pitch": 1
      }
    ],
    "area": {
      "facets": 11,
      "total": 2139
    },
    "pitch": [
      {
        "roof_pitch": "7/12",
        "area": 1026,
        "percentage": "47.98%"
      },
      {
        "roof_pitch": "4/12",
        "area": 405,
        "percentage": "18.95%"
      },
      {
        "roof_pitch": "8/12",
        "area": 629,
        "percentage": "29.4%"
      },
      {
        "roof_pitch": "6/12",
        "area": 68,
        "percentage": "3.17%"
      },
      {
        "roof_pitch": "1/12",
        "area": 11,
        "percentage": "0.51%"
      }
    ],
    "wireframe_facets_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_roof.png",
    "wireframe_measurements_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_roof.png?version=lengths",
    "wireframe_areas_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_roof.png?version=areas",
    "wireframe_pitches_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_roof.png?version=pitches"
  },
  "wireframes": {
    "front": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "front_right": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front_right.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front_right.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_front_right.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "right": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "right_back": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right_back.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right_back.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_right_back.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "back": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "back_left": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back_left.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back_left.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_back_left.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "left": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left.png?version=top",
      "metadata": {
        "version": 1
      }
    },
    "left_front": {
      "wireframe_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left_front.png",
      "compass_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left_front.png?version=compass",
      "top_url": "https://sandbox.hover.to/api/v2/jobs/20839/wireframe_images/wireframe_left_front.png?version=top",
      "metadata": {
        "version": 1
      }
    }
  },
  "captured_images": [
    "https://sandbox.hover.to/api/v2/images/33842/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33843/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33844/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33845/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33846/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33847/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33848/rotated_image.jpg?version=medium",
    "https://sandbox.hover.to/api/v2/images/33849/rotated_image.jpg?version=medium"
  ]
}';
    //</editor-fold>

    public function parseJob($tags, $job = null){

        if(!empty($job)){
            $this->job = json_decode($job,true);
        }else{
//            $this->job = json_decode($this->job,true);
        }

        foreach ($tags as $tagKey => $tagItem) {

            if(!empty($tagItem['method'])){

                $paramsArr = !empty($tagItem['params']) ? explode(',',$tagItem['params']) : [];
                $method = $tagItem['method'];
                $hoverValues = $this->$method($tagItem['field_type_slug'],$tagItem['config_path'],$paramsArr);

                if (!is_array($hoverValues)) {
                    $hoverValues = number_format($hoverValues, 2);
                    $tags[$tagKey]['hover_value'] = $hoverValues;
                } else {

                    if (empty($hoverValues[0])) {
                        $tags[$tagKey]['hover_value'] = $hoverValues['hover_value'];
                        $tags[$tagKey]['hover_data_title'] = $hoverValues['hover_data_title'];
                        $tags[$tagKey]['hover_data'] = $hoverValues['hover_data'];
                    } else {
                        $tags[$tagKey]['hover_value'] = $hoverValues;
                    }
                }

            }else if (!empty($tagItem['config_path'])) {
                $tags[$tagKey]['hover_value'] = $this->getByPath($tagItem['config_path']);
            }
        }
        //dd('parsed tags',$tags);
        return $tags;
    }

    public function parseJobCompletely($job,$tags = []){

        if(!empty($job)){
            $this->job = json_decode($job,true);
        }else{
//            $this->job = json_decode($this->job,true);
        }


        /** Get All hover fields */
        $fields = $this->getAllField();

//        pd($fields->toArray());

        /**

        [id] => 50
        [name] => Total Roof Area w/out Waste (sq)
        [hover_type_id] => 1
        [config_path] => roofing.total_area_wo_waste
        [params] =>
        [method] => getRoofArea
        [created_at] => 2021-02-10 03:27:37
        [updated_at] =>
        [deleted_at] =>
        [hover_field_type] => roof

         */

        /** Map all possible hover fields to their relevant returned values from
         *  - If hover field has method field set, its values will be returned from a method. Also, it can be single or multiple.
         *      - Multiple in-case of drop-down
         *      - Single in-case of text field
         */

        foreach ($fields AS $key => $field){
            $fields[$key]['hover_value'] = null;

            if(!empty($field['method'])){
                /** IF value is returned by a method */
                $paramsArr = !empty($field['params']) ? explode(',',$field['params']) : [];
                $method = $field['method'];
                $hoverValues = $this->$method($field['hover_field_type'],$field['config_path'],$paramsArr);

                if (!is_array($hoverValues)) {
                    $hoverValues = number_format($hoverValues, 2);
                    $fields[$key]['hover_value'] = $hoverValues;
                } else {

                    if (empty($hoverValues[0])) {
                        $fields[$key]['hover_value'] = $hoverValues['hover_value'];
                        $fields[$key]['hover_data_title'] = $hoverValues['hover_data_title'];
                        $fields[$key]['hover_data'] = $hoverValues['hover_data'];
                    } else {
                        $fields[$key]['hover_value'] = $hoverValues;
                    }
                }

            } else if (!empty($field['config_path']) and empty($field['method'])) {
                /** IF value is returned by a path */
                $fields[$key]['hover_value'] = $this->getByPath($field['config_path']);
            }

            //<editor-fold desc="Responses">
            /** Old response*/
//            "id": 81,
//            "company_id": 8,
//            "name": "Cornice return",
//            "ref_id": 74,
//            "ref_type": null,
//            "quantity": 0,
//            "has_qty": 1,

//            "hover_field_type_id": 1,
//            "hover_field_type_slug": "roof",
//            "hover_field_id": 1,
//            "hover_field_name": "Total Roof Area w/out Waste (sq)",
//            "hover_value": "102.46",
//            "hover_data_title": null,
//            "hover_data": null,
//            "created_at": null


            /** NEw response */
            //"id" => 1
            //"name" => "Total Roof Area w/out Waste (sq)"
            //"hover_type_id" => 1
            //"config_path" => "roofing.total_area_wo_waste"
            //"params" => null
            //"method" => "getRoofArea"
            //"created_at" => "2021-02-10 02:51:37"
            //"updated_at" => null
            //"deleted_at" => null
            //"hover_field_type" => "roof"
            //</editor-fold>

            $tag = collect($tags)->where('hover_field_id',$fields[$key]['id'])->where('hover_field_type_id',$field['hover_type_id'])->sortBy('created_at')->first();

            if (!empty($tag)) {
                $fields[$key]['tag_id'] = $tag['id'];
                $fields[$key]['ref_id'] = $tag['ref_id'];
                $fields[$key]['ref_type'] = $tag['ref_type'];
                $fields[$key]['has_qty'] = $tag['has_qty'];
            } else {
                $fields[$key]['tag_id'] = NULL;
                $fields[$key]['ref_id'] = NULL;
                $fields[$key]['ref_type'] = NULL;
                $fields[$key]['has_qty'] = NULL;
            }
        }

        $fields->transform(function($item) {
            return array_except($item, ['config_path','params','method','updated_at', 'deleted_at']);
        });

        return $fields->toArray();

    }

    public function parseJob_byPhotoview($photoViewTags, $job = null){

        if(!empty($job)){
            $this->job = json_decode($job,true);
        }else{
//            $this->job = json_decode($this->job,true);
        }

        foreach ($photoViewTags as $pKey => $pItem) {
            foreach ($pItem['category_tags'] AS $tagKey => $tagItem){
                if(!empty($tagItem['method'])){

                    $paramsArr = !empty($tagItem['params']) ? explode(',',$tagItem['params']) : [];
                    $method = $tagItem['method'];
                    $hoverValues = $this->$method($tagItem['field_type_slug'],$tagItem['config_path'],$paramsArr);

                    if(!is_array($hoverValues)){
                        $hoverValues = number_format($hoverValues, 2);
                        $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $hoverValues;
                    }else{
                        $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $hoverValues;
                    }

                }else if (!empty($tagItem['config_path']) AND  empty($tagItem['method'])) {
                    $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $this->getByPath($tagItem['config_path']);
                }
            }
        }


        return $photoViewTags;

    }

    public function getAllField(){

        return HoverField::join('hover_field_types AS hft','hft.id','hover_fields.hover_type_id')->selectRaw('hover_fields.*,hft.slug AS hover_field_type')->get();
    }

    /**IMPORTANT METHOD: Finds value from hover's job json using pattern based path*/
    public function getByPath($path, $job = null){

        $job = $job ?: $this->job;

        $path = explode('/',$path);
        $pathCount = count(((array) $path));
        $jobRef = &$job ;

        $wildcards = ['[all]'];
        foreach ($path as $pathKey => $pathItem) {

            if(array_key_exists($pathItem,$jobRef)){
                if (!is_numeric($pathItem)) {
                    $jobRef = &$jobRef[$pathItem];
                } else {
                    /** Getting first Key Value*/
                    ++$pathKey;
                    foreach ($jobRef AS $key => $value) {
                        if(!empty($value[$path[$pathKey]])){
                            $jobRef = $value[$path[$pathKey]];
                            if(is_array($jobRef)){
                                break ;
                            }else{
                                break 2;
                            }
                        }
                    }/*foreach end*/
                }/*IF-2 END*/
            }
            else if(in_array($pathItem,$wildcards)){
                /** Getting every Key Value*/
                ++$pathKey;

                $getValues = [];

                p($jobRef,'$jobRef');

                $cols = array_column($jobRef,$path[$pathKey]);
                pd($cols,'$cols');
                for ($i = $pathKey; $i < $pathCount; $i++) {
                    echo('<br>$pathKey: '.$pathKey);
                    echo('<br>$path[$pathKey]: '.$path[$pathKey]);
                    $cols = array_column($cols,$path[$pathKey]);
                    p(array_column($cols,$path[$pathKey]),'array_column');

                    $getValues[] = $cols;
                    ++$pathKey;
                }
                pd($getValues,'$getValues');
            }
            else {
                return ['error' => 'Invalid path','path' => $path,'part'=>$pathItem];
                /*echo "<br> else > $pathItem ";*/
            }

        }/*foreach end*/

        return $jobRef;
    }


    //<editor-fold desc="Calculations">
    private function getRoofAreaByPitch($field_type, $selectedSlug){

        /** Roof Pitch Ranges (From Formula sheet)
         * 0/12 - 6/12
         *  7/12 - 10/12
         *  11/12 - 12/12
         *  12/12+
         */
        $config =  config('hover.formulas.'.$selectedSlug);
        $condDataset = $this->getByPath($config['path']);
        $areaByPitch = [];
        foreach($condDataset AS $key => $item ){
            $pitchArr = explode('/',$item['roof_pitch']);

            if ($pitchArr[0] >= 0 AND $pitchArr[0] <= 6) {
                $areaByPitch['0/12 - 6/12'] += $item['area'];
            } else if ($pitchArr[0] >= 7 AND $pitchArr[0] <= 10) {
                $areaByPitch['7/12 - 10/12'] += $item['area'];
            } else if ($pitchArr[0] >= 11 AND $pitchArr[0] <= 12) {
                $areaByPitch['11/12 - 12/12'] += $item['area'];
            } else if ($pitchArr[0] > 12) {
                $areaByPitch['12/12+'] += $item['area'];
            }
        }
        return ['title' => $config['title'], 'data' => $areaByPitch] ;
    }

    public function getRoofArea($field_type, $selectedSlug){
        $config =  config('hover.formulas.'.$selectedSlug);
        $res = $this->getByPath($config['field_path']);
        return $res/100;
    }

    public function getWallArea($field_type, $selectedSlug){
        $config =  config('hover.formulas.'.$selectedSlug);

        $config['field_path'] = eval("return \"".$config['field_path']."\";");

        $res = $this->getByPath($config['field_path']);
        return $res/100;
    }

    public function getRoofArea_withWaste($field_type, $selectedSlug){
        $config =  config('hover.formulas.'.$selectedSlug);
        $res = $this->getByPath($config['waste_factor']);

        $arr= [];

        //<editor-fold desc="Getting only keys that has '_percent' in them">
        foreach($res AS $key => $item){
            if(strpos($key ,'_percent')){
                $keyExp = explode('_',$key);
                $arr[$keyExp[1]] = $item;
            }
        }
        //</editor-fold>

        $areaBy = $this->getRoofAreaByPitch($field_type,'roofing.area_by_pitch');

        return ['hover_value' => $arr ,'hover_data_title' => $areaBy['title'] ,'hover_data' => $areaBy['data']];
    }

    public function getWallArea_withWaste($field_type, $selectedSlug){

        /** $field_type is used in ref_path from config file*/
        $config =  config('hover.formulas.'.$selectedSlug);

        $refPath = $config['ref_path'];
        $res = eval("return \"$refPath\";");

        $eWalls = $this->getByPath($res);
        $siding = $this->getByPath($config['path']);

        if($eWalls['error']){
            throw new \Exception('Unable to get hover details from path');
        }

        $eWalls = array_merge(...$eWalls);

        $wasteFactorArr = [];
        /** Getting all wall ids*/
        foreach ($siding AS $pKey => $pItem){

            $wasteFactor = $this->getByPath($config['waste_factor'],$pItem);

            if(!empty($eWalls[$pItem['facade']])){                                              /** IF Facade ($pItem['facade']) is present in Wall ids of Elevation */
//                echo "<br>".$pItem['facade'];

                $wasteFactorArr['0'][$pItem['facade']] = $eWalls[$pItem['facade']];             /** zero waste factor area is default at  elevations/sides/front/area_per_label */

                /** Traversing waster_factor array */
                //<editor-fold desc="Getting only keys that has '_percent' in them">
                foreach ($wasteFactor AS $key => $item) {
                    if (strpos($key, '_percent')) {
                        $keyExp = explode('_', $key);

                        if(is_numeric($keyExp[1])){                                             /** For matching plus_10_percent */
                            $wasteFactorArr[$keyExp[1]][$pItem['facade']] = $item;
                        }
                    }
                }
                //</editor-fold>
            }
        }


        /** Adding all wall areas to get elevation area*/
        foreach ($wasteFactorArr AS $wfKey => $wfItem){
            $wasteFactorArr[$wfKey] = array_sum($wasteFactorArr[$wfKey]);
        }

        return $wasteFactorArr;
    }

    public function getSidings($field_type, $selectedSlug, $params)
    {
        /** $field_type is used in ref_path from config file*/

        $config =  config('hover.formulas.'.$selectedSlug);

        $refPath = $config['ref_path'];

        $res = eval("return \"$refPath\";");

        $eWalls = $this->getByPath($res);
        $siding = $this->getByPath($config['path']);

//        p($res,'$res');
//        pd($eWalls,'$eWalls');

        if($eWalls['error']){
            throw new \Exception('Unable to get hover details from path');
        }

        $eWalls = array_merge(...$eWalls);

        foreach ($siding AS $pKey => $pItem){
            $fields = $this->getByPath($params[0],$pItem);
            if(!empty($eWalls[$pItem['facade']])){
                $eWalls[$pItem['facade']] = $fields;
            }
        }

//        p($field_type,'$field_type');
//        p($sidingType,'$sidingType');
//        p($eWalls,'Siding wall wise');
//        pd(array_sum($eWalls),'SUM');

        return array_sum($eWalls);
    }

    public function getElevationsFacadeWise($field_type,$selectedSlug){

        $config =  config('hover.formulas.'.$selectedSlug);

        $refPath = $config['ref_path'];

        $res = eval("return \"$refPath\";");

        $eWalls = $this->getByPath($res);
        $path = $this->getByPath($config['path']);

        $eWallsArr = array_keys(array_merge(...$eWalls));

        $levelStarterWithWalls = [];
        foreach ($path AS $condKey => $condItem){
            if(in_array($condItem['facade'],$eWallsArr)){

                pd($condItem,'$condItem');

                /** Trim */
                $levelStarterWithWalls[$condItem['facade']]['trim']['level_starter'] += $condItem['trim']['level_starter'];
                $levelStarterWithWalls[$condItem['facade']]['trim']['sloped'] += $condItem['trim']['sloped'];
                $levelStarterWithWalls[$condItem['facade']]['trim']['vertical'] += $condItem['trim']['vertical'];

                /** Roofline */
                $levelStarterWithWalls[$condItem['facade']]['roofline']['level_frieze_board'] += $condItem['roofline']['level_frieze_board'];
                $levelStarterWithWalls[$condItem['facade']]['roofline']['sloped_frieze_board'] += $condItem['roofline']['sloped_frieze_board'];

                /** corners */
                $levelStarterWithWalls[$condItem['facade']]['corners']['inside_length'] += $condItem['corners']['inside_length'];
                $levelStarterWithWalls[$condItem['facade']]['corners']['outside_length'] += $condItem['corners']['outside_length'];
            }
        }

        pd($levelStarterWithWalls,'$levelStarterWithWalls');

        p($refPath,'$config');
        p($res,'$res');
        pd($eWalls,'$eWalls');
    }

    public function parseSampleJob($photoViewTags){


        if(!empty($job)){
            $this->job = json_decode($job,true);
        }else{
            $this->job = json_decode($this->job,true);
        }

        foreach ($photoViewTags as $pKey => $pItem) {
            foreach ($pItem['category_tags'] AS $tagKey => $tagItem){
                if(!empty($tagItem['method'])){

                    $paramsArr = !empty($tagItem['params']) ? explode(',',$tagItem['params']) : [];
                    $method = $tagItem['method'];
                    $hoverValues = $this->$method($tagItem['field_type_slug'],$tagItem['config_path'],$paramsArr);

                    if(!is_array($hoverValues)){
                        $hoverValues = (float) number_format($hoverValues, 2);

//                        pd($hoverValues,'$hoverValues');
                        $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $hoverValues;
                    }else{
                        $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $hoverValues;
                    }
//

                }else if (!empty($tagItem['config_path']) AND  empty($tagItem['method'])) {
                    $photoViewTags[$pKey]['category_tags'][$tagKey]['hover_value'] = $this->getByPath($tagItem['config_path']);
                }
            }
        }
        return $photoViewTags;
    }
    //</editor-fold>
}


