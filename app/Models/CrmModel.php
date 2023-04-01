<?php

namespace App\Models;

use App\Libraries\Helper;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class CrmModel extends Model
{
    protected $table = "crm";

    protected $fillable = [ 'company_id', 'identifier', 'access_token', 'refresh_token', 'token_type', 'expires_at' ];

    public $specTypes = [
        'Roofing Specs',
        'Gutter Specs',
        'Siding Specs',
        'Garage Door Specs',
        'Insulation Specs',
    ];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getByIdentifier($identifier){

        $query = self::select();
        return $query->where('identifier', $identifier)
            ->first();
    }

    public static function parseProjectSpecs($projects){
        $crmSpecs= [];
        foreach ($projects AS $pKey => $pItem) {

            $crmSpecs[$pKey]['id'] = $pItem['id'];
            $crmSpecs[$pKey]['project_id'] = $pItem['crm_project_id'];
            $crmSpecs[$pKey]['employee_id'] = $pItem['company']['crm_employee_id'];
            foreach ($projects[$pKey]['project_media'] AS $mediaKey => $mediaItem) {

                /** Setting build spec*/
                if (!empty($mediaItem['tags_data'])) {
                    foreach ($mediaItem['tags_data'] AS $tagKey => $tagItem) {
                        if (!empty($tagItem['spec_type'])) {
                            $crmSpecs[$pKey]['build_spec'][$tagItem['spec_type']]['type'] = $tagItem['spec_type'];
                            $crmSpecs[$pKey]['build_spec'][$tagItem['spec_type']][$tagItem['build_spec']] += $tagItem['qty'];
                        }
                    }
                }

                /** Setting images base64*/
                $absPath = base_path().'/public/'.config('constants.MEDIA_IMAGE_PATH').$mediaItem['path'];
                if (file_exists($absPath)) {
                    $crmSpecs[$pKey]['images'][$mediaKey]['image'] = base64_encode(file_get_contents($absPath));
//                    $crmSpecs[$pKey]['images'][$mediaKey]['image'] = "base64_encode(file_get_contents(absPath))";
                    $crmSpecs[$pKey]['images'][$mediaKey]['metadata'] = [
                        'name' => $mediaItem['path'],// "string",
                        'date_taken' => date('Y-m-d H:i:s', strtotime($mediaItem['created_at'])),// "date with timezone",
                        'description' => $mediaItem['note'],// "string",
                        'folder_name' => "",// "string"
                    ];
                } else {
//                    $crmSpecs[$pKey]['build_spec']['images'][$mediaKey]['image'] = "N/A";
                }
            }

            if (empty($crmSpecs[$pKey]['build_spec'])) {
                $crmSpecs[$pKey]['error'] = "Project doesn't have build_spec";
            }else{
                $crmSpecs[$pKey]['build_spec'] = array_values($crmSpecs[$pKey]['build_spec']);
            }
        }
        return $crmSpecs;
    }

    public static function parseProjectImages($media){

//        Helper::p($media->toArray(),'$specTypes');
//        Helper::p($specTypes,'$specTypes');
        $crmImages = [];
        $metadata = [
            'name' =>  "" ,// "string",
            'date_taken' =>  "" ,// "date with timezone",
            'description' =>  "" ,// "string",
            'folder_name' =>  "" ,// "string"
        ];

        foreach ($media AS $key => $item){

        }
        return $crmImages;
    }
}
