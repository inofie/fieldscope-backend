<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class ProjectMediaTag extends Model
{
    protected $table = "project_media_tag";

    use SoftDeletes;

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $fillable = [
        'target_id',
        'target_type',
        'tag_id',
        'name',
        'qty',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function createRecords($projectMediaId,$tags)
    {

        if(!empty($tags)){
            foreach ($tags AS $key => $item){
              
              $tag = Tag::where('id',$item['id'])->count();
              if($tag < 1 ){
                  /*Create New Tag (AdditionalPhotos)*/                  
                $tagFields['created_at']    = date('Y-m-d H:i:s');
                $tagFields['company_id']    = $item['company_id'];
                $tagFields['ref_id']        = $item['ref_id'];
                $tagFields['ref_type']      = $item['ref_type'];
                $tagFields['name']          = $item['name'];
                $tagFields['has_qty']       = $item['has_qty'];                      
                $item['id']           = Tag::insertTag($tagFields);                  
              }

                $data['target_id']  = $projectMediaId;
                $data['tag_id']     = $item['id'];
                $data['qty']        = isset($item['quantity']) ? $item['quantity'] : 0;

                $where = ['target_id' => $data['target_id'], 'tag_id'=> $data['tag_id']];
//               Helper::p($where);
                $pMediaTag = self::where($where)->count();

                $res = false;
                if ($pMediaTag == 0) {
                    /*Insert IF ProjectMediaTag Not Exists*/
                  
                    $data['created_at'] = '' . date('Y-m-d H:i:s');
                    
//                   echo "instering";
                  $res = self::insert($data);
                    if (!$res) {
                        /*Failed*/
                        return false;
                    }
                } else {
                    /* ELSE Update ProjectMediaTag Exists */
                  
                    $data['updated_at'] = '' . date('Y-m-d H:i:s');
                    $res = self::where(['target_id' => $data['target_id'], 'tag_id' => $data['tag_id']])->update($data);
                    if (!$res) {
                        /*Failed*/
                        return false;
                    }
                }
                
            }/*End foreach*/
            return true;
        }
        return false;
    }

    public static function getById($id)
    {
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function getList($param)
    {
        $query = self::select();
        $query->where('company_id', $param['company_id']);

        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
                $where->orWhere('address1', 'LIKE', "'%$keyword%'");
            });
        }
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getByProjectId($projectId,$columns = []){
        $q = self::
        join('project_media AS pm', function ($join){
                $join->on('pm.id', '=', 'project_media_tag.target_id');
//                $join->on('pm.deleted_at', '=', NULL);
                $join->where('project_media_tag.target_type', '=', 'media');
        })->join('tag AS t','t.id','=','project_media_tag.tag_id');

        $q->where('pm.project_id',$projectId);

        if(!empty($columns)){
            $q->select($columns);
        }else{
            $q->selectRaw('project_media_tag.*,t.*');
        }
        return $q->get();
    }

    public static function updateMediaTag($id,$param){
        $upRes = ['res' => TRUE];
        if(!empty($param['pmt_tag_id'])){
            foreach ($param['pmt_tag_id'] as $key => $item) {

                $upRes['res'] = self::where(['target_id' => $id, 'tag_id' => $item])->update(['qty' => $param['pmt_qty'][$key]]);

                if(!$upRes['res']){
                    $upRes['error'] = "Error at Media $id, Tag Id $id";
                    break;
                }
            }
        }
        return $upRes;
    }

    public static function storeCompanyGroupCategory($request)
    {
        return \DB::table('company_group_category')->insertGetId([
        ]);
    }

    public function scopeWithTagRefs($q,$param){
        $q->join('tag','tag.id','=','project_media_tag.tag_id');
    }

    public static function getComHoverFieldsByProjectId($projectId,$columns = []){

        $q = self::
        join('project_media AS pm', function ($join){
            $join->on('pm.id', '=', 'project_media_tag.target_id');
//                $join->on('pm.deleted_at', '=', NULL);
            $join->on('project_media_tag.target_type', '=', \DB::raw("'media'"));
        })->join('tag AS t','t.id','=','project_media_tag.tag_id')

            ->join('hover_fields AS hf',function ($join){
                $join->on('hf.id','t.hover_field_id');
                $join->on('hf.hover_type_id','t.hover_field_type_id');
            })

            ->join('hover_field_types AS hft','hft.id','=','hf.hover_type_id');
        ;

        $q->where('pm.project_id',$projectId);

        if(!empty($columns)){
            $q->select($columns);
        }else{
            $q->selectRaw('project_media_tag.*,t.*,hf.*');
        }
        return $q->get();
    }


    /** "->where('target_type', 'media')"  causing an error not sure where it is getting used so replicating it below 29-Jul-20 */
    public function tags(){
        return $this->belongsTo('App\Models\Tag','tag_id' , 'id')->where('target_type', 'media');
    }

    public function ref_tags(){
        return $this->belongsTo('App\Models\Tag','tag_id' , 'id');
    }
}
