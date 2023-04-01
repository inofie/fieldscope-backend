<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectShareMedia extends Model
{
    use SoftDeletes,GeneralModelTrait;
    protected $table = "project_share_media";

    protected $fillable = ['project_share_id', 'media_id'];


    public static function getMedia_byShare(ProjectShare $projectShare,$request ){

        $q = self::leftJoin('project_media','project_media.id','=','project_share_media.media_id')
            ->select('project_share_media.id','project_media.id AS media_id','project_media.path','project_media.created_at');

        if($request['category_ids'])
            $q->where('project_media.category_id',$request['category_ids']);

        if($request['date'])
            $q->whereDate('project_media.created_at','=','2021-04-16');



        return $q->whereNull('project_media.deleted_at')->where(['project_share_id' => $projectShare['id']])->paginate(config('constants.PAGINATION_PAGE_SIZE'));
        /** Get */
    }

}
