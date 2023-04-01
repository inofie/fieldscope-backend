<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvProductFields extends Model
{
    protected $table = "ev_product_fields";

    protected $fillable = [ 'id', 'primary_product_id', 'name', 'created_at', 'updated_at', 'deleted_at' ];



    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public function getEvFields($params,$report){

        $params['type'] = 2;
        $category = Category::getCompanyPhotoView($params)->WithTagsAndEvFields();
        $catArr = $category->get()->toArray();

        $units = [' sq. ft',' ft'];

        foreach($catArr AS $cKey => $cItem){
            foreach ($cItem['category_tags'] AS $tKey => $tItem){

                if($report['StatusId'] == 5){
                    foreach ($units AS $uItem) {
                        if (preg_match('/\b' . $uItem . '\b/', $report[$tItem['ev_field_name']])) {
                            $catArr[$cKey]['category_tags'][$tKey]['ev_field_value'] = str_replace($uItem, '', $report[$tItem['ev_field_name']]);
                            $catArr[$cKey]['category_tags'][$tKey]['ev_field_unit'] = ltrim($uItem);
                        }
                    }
                }else{
                    $catArr[$cKey]['category_tags'][$tKey]['ev_field_value'] = "";
                    $catArr[$cKey]['category_tags'][$tKey]['ev_field_unit'] = "";
                }
            }
        }

        return $catArr;
    }

    public function parseTags(){}


}
