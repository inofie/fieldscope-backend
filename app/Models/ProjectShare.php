<?php

namespace App\Models;
use App\Traits\GeneralModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectShare extends Model
{
    use SoftDeletes,GeneralModelTrait;

    protected $table = "project_shares";

    protected $fillable = ['company_id', 'project_id', 'share_token', 'recipient_email', 'status', 'creator_id'];


    public static function createShare($params){

        $insert = [];

        $data['company_id'] = $params['company_id'];
        $data['project_id'] = $params['project_id'];
        $data['recipient_email'] = null;
        $data['status'] = 1;
        $data['creator_id'] = $params['user_id'];

        if(!empty($params['email'])){
            $data['recipient_email'] = $params['email'];
            $insert[] = $data;
        }

        if(!empty($params['user_id'])){
            $data['recipient_email'] = User::getById($params['user_id'])['email'];
            $insert[] = $data;
        }

        if(!empty($insert)){
            $ids = null;
            foreach ($insert as $key => $item) {
                $insert[$key]['share_token'] = self::make_unique('share_token',str_random(40));
                $ids[] = self::insertGetId($insert[$key]);

                $mailParams['LINK'] = url('project/photos/'.$insert[$key]['share_token']);
                self::sendMail('photo_share',$insert[$key]['recipient_email'],$mailParams);
            }
        }

        $mediaInsert = [];
        foreach ($ids as $idItem) {
            foreach ($params['media_ids'] as $key => $item) {
                $mediaInsert[] = ['project_share_id' => $idItem, 'media_id' => $item];
            }
        }
        return ProjectShareMedia::insert($mediaInsert) ?? ['error' => 'Unable to add record.'];
    }

    public static function changeStatus($id,$status){
        $q = self::find($id);

        $q->status = $status == 'active' ? 1 : 0;
        return $q->save();
    }

    public function project(){
        return $this->belongsTo('App\Models\Project','project_id','id');
    }

    public function media(){
        $mediaPath = url(config('constants.MEDIA_IMAGE_PATH')).'/';
        //pd($mediaPath,'$mediaPath');
        return $this->hasMany('App\Models\ProjectShareMedia','project_share_id','id')
            ->leftJoin('project_media','project_media.id','=','project_share_media.media_id')
            ->select('*')
            ->addSelect(\DB::raw("CONCAT('$mediaPath',path) AS image_url"))
            ;
    }



}
