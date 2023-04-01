<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "project_media";

    public static function createBulk($source_id, $source_type, $media_type, $data)
    {

        $qry_params = [];
        $media_type_map['image'] = ['jpeg','png','jpg','gif','svg'];
        $media_type_map['pdf'] = ['pdf'];

        foreach ($data as $column => $media) {
            $ext = explode('.', $media)[1];

            foreach($media_type_map as $ext_key => $ext_types){
                if(in_array($ext,$ext_types))
                    $media_type = $ext_key;
            }

            $qry_params[] = "($source_id, '$source_type', '$media_type', '$media', NOW()) ";
        }

        /*print 'INSERT INTO user (source_id, source_type, path, created_at) VALUES ' . implode(', ', $qry_params) ;
        exit;*/
        \DB::statement('INSERT INTO media (source_id, source_type, media_type, path, created_at) VALUES ' . implode(', ', $qry_params) . "");
        return true;

    }

    public static function getBySourceType($source_id, $source_type)
    {
        $query = self::select();
        return $query->where('source_id', $source_id)
            ->where('source_type', $source_type)
            ->whereNull('deleted_at')
            ->get();

    }

    public static function deleteByIds($ids, $source_id)
    {
        \DB::statement("Update media set deleted_at = NOW() WHERE  source_id = $source_id AND id IN ($ids)");
        return;

    }

    public static function deleteBySourceId($source_id)
    {
        \DB::statement("Update media set deleted_at = NOW() WHERE source_id = $source_id");
        return;

    }


    public function source()
    {
        return $this->morphTo('source','source_type','source_id');
    }
}
