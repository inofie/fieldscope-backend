<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;


class ProjectMedia extends Model
{
    protected $table = "project_media";

    use SoftDeletes,GeneralModelTrait;

    public static function createBulk($project_id, $category_id, $note, $media_type, $data)
    {
        $qry_params = [];
        $media_type_map['image'] = ['jpeg', 'png', 'jpg', 'gif', 'svg'];
        $media_type_map['pdf'] = ['pdf'];

        foreach ($data as $column => $media) {
            $ext = explode('.', $media)[1];

            foreach ($media_type_map as $ext_key => $ext_types) {
                if (in_array($ext, $ext_types))
                    $media_type = $ext_key;
            }

            $qry_params[] = "($project_id, '$category_id', '$media_type', '$media','$note', NOW()) ";
        }

        \DB::statement('INSERT INTO project_media (project_id, category_id, media_type,path, note, created_at) VALUES ' . implode(', ', $qry_params) . "");

        return true;

    }

    public static function createUniqueMedia($path,$uId, $categoryId = 0,$note = ""){

        $insert = [];
        $insert['project_id']  = $uId;
        $insert['category_id']  = $categoryId;
        $insert['ref_id']  = $uId;
        $insert['path'] =  $path;
        $insert['note'] = $note;
        $insert['created_at']  = date('Y-m-d H:i:s');
        $insert['media_type']   = 'image';
        return self::insertGetId($insert);
    }

    public static function updateUniqueMedia($path,$uId, $categoryId = 0,$note = ""){

        $where = [];
        $where['ref_id'] = $uId;
        $where['category_id'] = $categoryId;

        $update = [];
        $update['project_id']  = $uId;
        $update['category_id']  = $categoryId;
        $update['ref_id']  = $uId;
        $update['path'] =  $path;
        $update['note'] = $note;

        $update['created_at']  = date('Y-m-d H:i:s');
        $update['media_type']   = 'image';
        return self::where($where)->update($update);
    }

    public static function updateCategoryId_AndMediaTags($media, $projectId)
    {
        $mediaRefIds = array_column($media, 'id');

        foreach ($media as $key => $item) {
            $update = [
                'project_id' => $projectId,
                'category_id' => $item['category_id'],
                'note' => $item['note']
            ];

            $updateRes = self::where('ref_id', $item['id'])->update($update);
            if(!$updateRes){
                $update['ref_id'] = $item['id'];
                $res['error_data'] = $update;
                $res['error'] = 'Unable to update Media ref.';
                return $res;
            }

            $mediaData = self::where('ref_id', $item['id'])->first();

            //<editor-fold desc="Deleted Tags Block">
            if (!empty($item['deleted_tags'])) {
                $pMedia = self::withTrashed()->where(['ref_id' => $item['id']])->first();

                if (count(((array) $pMedia)) > 0) {
                    ProjectMediaTag::whereIn('tag_id', $item['deleted_tags'])
                        ->where(['target_id' => $pMedia['id'], 'target_type' => 'media'])->delete();
                } else {
//                    echo 'else';
                }
            }
            //</editor-fold>

            if (!empty($mediaData['id'])) {

                if(!empty($item['tags'])){
                    $tagsIds = array_column($item['tags'], 'id');
                    $tags = Tag::whereIn('id', $tagsIds)->count();

                    if ($tags < 1) {
                        /*Create New Tags (AdditionalPhotos)*/
                        foreach ($item['tags'] AS $tagKey => $tagItem) {
                            $tagFields['created_at'] = date('Y-m-d H:i:s');

                            $tagFields['company_id'] = $tagItem['company_id'];
                            $tagFields['ref_id'] = $tagItem['ref_id'];
                            $tagFields['ref_type'] = $tagItem['ref_type'];
                            $tagFields['name'] = $tagItem['name'];
                            $tagFields['has_qty'] = $tagItem['has_qty'];
                            $item['tags'][$tagKey]['id'] = Tag::insertTag($tagFields);
                        }
                    }

                    $pMediaTag = ProjectMediaTag::createRecords($mediaData['id'], $item['tags']);
                }else{
//                    $res['error_data'] = $item;
//                    $res['error'] = 'Unable to find tags in request';
//                    return $res;
                }


            } else if (!empty($item['tags']) && empty($mediaData['id'])) {

                $res['error_data'] = $item;
                $res['error'] = 'Unable to find Media for tags creation';
                return $res;
            } else {
                $res['error_data'] = $item;
                $res['error'] = 'Unable to find Media';
                return $res;
            }

        } // End foreach


        return self::whereIn('ref_id', $mediaRefIds)->get();
    }

    public static function getByProjectId($project_id)
    {
        $query = self::select();
        return $query->where('project_id', $project_id)
            ->get();
    }

    public static function getAllBy($where)
    {
        $query = self::select();
        $mediaPath = Config::get('constants.MEDIA_IMAGE_PATH');
        $query->selectRaw("CONCAT('$mediaPath',path) image_path");
        return $query->where($where)
            ->get();
    }

    public static function getById($id,array $with = [])
    {
        $query = self::select();

        if(!empty($with)){
            $query->with($with);
        }
        return $query->where('id', $id)
            ->first();
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

    public static function getMediaForCategories($categories,$projectId)
    {

        $where['project_id'] = $projectId;
        foreach ($categories AS $key => $item) {

            $where['category_id'] = $item['id'];

            $projectMedia = self::getAllBy($where);

            $categories[$key]['media'] = !empty($projectMedia->toArray()) ? $projectMedia->toArray() : [];

            if (!empty($projectMedia)) {
                $categories[$key]['media_count'] += count(((array) $projectMedia->toArray()));
            }

            if (count(((array) $item['get_child'])) > 0) {
                foreach ($item['get_child'] AS $keyChild => $itemChild) {
                    $projectMedia = [];
                    $where['category_id'] = $itemChild['id'];
                    $projectMedia = self::getAllBy($where);
                    $categories[$key]['get_child'][$keyChild]['media'] = NULL;
                    $categories[$key]['get_child'][$keyChild]['media'] = !empty($projectMedia) ? $projectMedia->toArray() : NULL;
                    if (!empty($projectMedia)) {
                        $categories[$key]['media_count'] += count(((array) $projectMedia->toArray()));
                    }
                }
            }
        }

        return $categories;
    }

    public static function checkProjectRequiredMedia($categories, $projectId)
    {
        $categoryIds = array_column( $categories , 'id');
        $catIm = implode(',',$categoryIds);
        $sql = "SELECT pm.*,c.`name`,c.`min_quantity`, IF( media_count = min_quantity , TRUE , FALSE) AS match_result
                    FROM (
                                SELECT
                                  category_id,
                                  COUNT(id) AS media_count
                                FROM
                                  `project_media`  
                                WHERE `project_id` = $projectId
                                  AND `category_id` IN ($catIm)
                                GROUP BY `category_id`
                    ) pm
                    LEFT JOIN category c ON c.id = pm.category_id ";
//        echo $sql;
        $query = \DB::select($sql);
        return $query;
    }

    public static function addImageText ($param = []){

        $category = Category::getById($param['category_id']);
        $user = User::getById($param['user_id']);

        $fontConfig = [
            'path' => public_path('assets/fonts/report-font/Axiforma/FontsFree-Net-Axiforma2woff2.ttf'),
            'color' => '#464648',
            'size' => 10,
            'angle' => 0,
        ];

        $imagePath = public_path(config('constants.MEDIA_IMAGE_PATH') . $param['image_path']);

        $img = Image::make($imagePath);
        $img->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $orgHeight = $img->height();
        $prevWidth = $img->width();

        if($param['mode'] == 'update'){

        }else{
            $img->resizeCanvas(0, 80, 'top-left', true,'#E6E6E6');
        }

        $colOneTextX = 10;
        $textBr = 15;
        $colOneTextY = $orgHeight ;
        $colOneTextY = $colOneTextY + $textBr;

        //<editor-fold desc="Column 01">

        /*Col 1 Pt 1*/
        $img->text('Area: '.$category['name'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);;
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 2*/
        $nameImploded = implode(', ',array_column($param['tags'],'name'));
        $nameImploded = strlen($nameImploded) > 20 ? substr($nameImploded,0,20)."..." : $nameImploded;
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Photo Tag: '.$nameImploded, $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);;
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 3*/
        $qtyImploded = '';
        foreach ($param['tags'] as $tag) {
            /*Not imploded cuz 'quantity' is optional key */
            if(isset($tag['quantity']) ){
                $qtyImploded .= $tag['quantity'].', ';
            }else{
                $qtyImploded .= 'N.A, ';
            }
        }
        $qtyImploded = strlen($qtyImploded) > 20 ? substr($qtyImploded,0,20)."..." : $qtyImploded;
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Qty: '.$qtyImploded, $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Annotation: '.$param['note'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });


        /*Col 1 Pt 4*/
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Powered By: Field Scope', $colOneTextX , (int)($colOneTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });
        //</editor-fold>


        //<editor-fold desc="Column 02">
        $colTwoTextX = ($prevWidth/2) - $colOneTextX;
        $colTwoTextY = $orgHeight ;

        /*Col2 Pt 1*/
        $img->text('Location Verified: Lat: '.$param['latitude'].',', $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col2 Pt 1*/
        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Long: '.$param['longitude'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col2 Pt 2*/
        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Inspector: '.$user['first_name'].' '.$user['last_name'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col2 Pt 3*/
        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Claim #: '.$param['claim_no'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col2 Pt 4*/
        $param['inspection_date'] = date('Y-m-d', strtotime($param['inspection_date']));
        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Inspection Date: '.$param['inspection_date'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });
        //</editor-fold>

        $img->save($imagePath);
        return true;
    }

    public static function addImageText_2 ($param = []){

        /** Docmentation:
         * public Intervention\Image\Image resizeCanvas (int $width, int $height, [string $anchor, [boolean $relative, [mixed $bgcolor]]])
         * public Intervention\Image\Image rectangle(int $x1, int $y1, int $x2, int $y2, [Closure $callback])
         */

        $category = Category::getById($param['category_id']);
        $user = User::getById($param['user_id']);

        $fontConfig = [
            'path' => public_path('assets/fonts/report-font/Axiforma/Kastelov - Axiforma SemiBold.otf'),
            'color' => '#464648',
            'size' => 13,
            'angle' => 0,
        ];

        $imagePath = public_path(config('constants.MEDIA_IMAGE_PATH') . $param['image_path']);

        $img = Image::make($imagePath);

        if($param['mode'] != 'update'){
            $img->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $orgHeight = $img->height();
        $prevWidth = $img->width();


        /** Configs  */
        $detailCanvasHeight = 165;
        $tCols = 2;
        $textBr = 25;
        $footerHeight = 20;

        $colOneTextX = 10;
        $colOneTextY = $orgHeight + $textBr;

        $colTwoTextX = ($prevWidth/$tCols);
        $colTwoTextY = $orgHeight  + $textBr;

        if($param['mode'] == 'update'){
            /** When blue-ribbon / watermark is already a part of image*/

            $blueRectY1 = ($orgHeight - ($detailCanvasHeight+$footerHeight));
            $blueRectY2 = ($orgHeight - ($footerHeight));

            // +2 is for removing "top white line"
            $colOneTextY = ($orgHeight - ($detailCanvasHeight+$footerHeight)) + $textBr;
            $colTwoTextY = ($orgHeight - ($detailCanvasHeight+$footerHeight)) + $textBr;

            $footerY =

            // public Intervention\Image\Image rectangle(int $x1, int $y1, int $x2, int $y2, [Closure $callback])
            // draw a blue rectangle
            $img->rectangle(0, $blueRectY1, $prevWidth, $blueRectY2, function ($draw) {
                $draw->background('#E6E6E6');
                //#d5db14
            });
        }else{
            /** When blue-ribbon / watermark isn't already a part of image*/
            //adding top white line
            $img->resizeCanvas(0, 2, 'top-left', true, '#ffffff');

            // adding top white line
            $img->resizeCanvas(0, $detailCanvasHeight, 'top-left', true,'#E6E6E6');
        }



        //<editor-fold desc="Col 1">
        /*Col 1 Pt 1*/
        $img->text('Area: '.$category['name'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);;
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 2*/
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Inspector: '.$user['first_name'].' '.$user['last_name'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);;
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 3*/
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Claim #: '.$param['claim_no'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });


        // draw horizontal line (rectangle)
        $img->rectangle(10, $colOneTextY+7, $prevWidth-10, $colOneTextY+7+1, function ($draw) {
            $draw->background('#ffffff');
        });

        /*Col 1 Pt 4*/
        $colOneTextY = $colOneTextY + $textBr;

        $nameImploded = implode(', ',array_column($param['tags'],'name'));
        $nameImploded = strlen($nameImploded) > 40 ? substr($nameImploded,0,40)."..." : $nameImploded;
//        $nameImploded = "100 char string Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenassean dolor. Aenea end";
        $img->text('Photo Tag: '.$nameImploded, $colOneTextX , (int)($colOneTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 5*/
        $colOneTextY = $colOneTextY + $textBr;

        $qtyImploded = '';
        foreach ($param['tags'] as $tag) {
            /** Not imploded cuz 'quantity' is optional key */
            if(isset($tag['quantity']) ){
                $qtyImploded .= $tag['quantity'].', ';
            }else{
                $qtyImploded .= 'N.A, ';
            }
        }
        $qtyImploded = strlen($qtyImploded) > 40 ? substr($qtyImploded,0,40)."..." : $qtyImploded;
        $img->text('Qty: '.$qtyImploded , $colOneTextX , (int)($colOneTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 1 Pt 6*/
        $colOneTextY = $colOneTextY + $textBr;
        $img->text('Annotation: '.$param['note'], $colOneTextX , $colOneTextY ,function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });
        //</editor-fold>

        //<editor-fold desc="Col 2">

        /*Col 2 Pt 1*/

        // draw vertical line (rectangle)
        $img->rectangle($colTwoTextX-10, $colTwoTextY-15, $colTwoTextX-9, $colTwoTextY+50, function ($draw) {
            $draw->background('#ffffff');
        });

        /*Col 2 Pt 1*/
        $img->text('Location Verified: Lat: '.$param['latitude'].',', $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 2 Pt 2*/
        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Long: '.$param['longitude'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 2 Pt 3*/
        $param['inspection_date'] = date('Y-m-d', strtotime($param['inspection_date']));

        $colTwoTextY = $colTwoTextY + $textBr;
        $img->text('Inspection Date: '.$param['inspection_date'], $colTwoTextX , (int)($colTwoTextY),function($font) use($fontConfig) {
            $font->file($fontConfig['path']);
            $font->size($fontConfig['size']);
            $font->color($fontConfig['color']);
            /*$font->align('center');
            $font->valign('top');*/
            $font->angle($fontConfig['angle']);
        });

        /*Col 2 Pt 4*/
//        $colTwoTextY = $colTwoTextY + $textBr;


        /*Col 2 Pt 5*/
//        $colTwoTextY = $colTwoTextY + $textBr;

        //</editor-fold>

        if($param['mode'] != 'update'){
            //<editor-fold desc="Footer ">
            $img->resizeCanvas(0, $footerHeight, 'top-left', true,'#ffffff');

            $fontConfig = [
                'path' => public_path('assets/fonts/report-font/Axiforma/Kastelov - Axiforma SemiBold.otf'),
                'color' =>   '#E6E6E6', // '#ff0000',
                'size' => 10,
                'angle' => 0,
            ];

            $colOneTextY = $orgHeight + $detailCanvasHeight + 15;
            $footerY =
                $img->text('Powered By: Field Scope', $colOneTextX , (int)($colOneTextY),function($font) use($fontConfig) {
                    $font->file($fontConfig['path']);
                    $font->size($fontConfig['size']);
                    $font->color($fontConfig['color']);
                    /*$font->align('center');
                    $font->valign('top');*/
                    $font->angle($fontConfig['angle']);
                });
            //</editor-fold>
        }


        $img->save($imagePath);
        return true;
    }

    public static function getLatestPhotos($params){

        $params['project_ids'] = !empty($params['project_ids']) ? [$params['project_ids']] : [];
        $params['user_ids'] = !empty($params['user_ids']) ? [$params['user_ids']] : [];
        $params['tag_ids'] = !empty($params['tag_ids']) ? [$params['tag_ids']] : [];

        $q = self::select()->with(['media_tags']);

        $pmCols = self::customColumn('0', ['id', 'project_id', 'category_id', 'path', 'created_at','updated_at', 'note']);
        $uCols = User::customColumn(1, ['first_name', 'last_name', 'email', 'image_url'],'u');
        $pCols = Project::customColumn(1, ['name','user_id', 'created_at'], 'p');
        $q->select(array_merge($pmCols,$uCols,$pCols));
        $q->join('project','project.id','=','project_id');
        $q->join('user','user.id','=','project.user_id');
        $q->where(['project.company_id' => $params['company_id']]);


//        $params['project_ids'] = ['159'];
//        $params['user_ids'] = 0;
//        $params['tag_ids'] = [1];
//        $params['date'] = '09-Jun-20';


        //region Filters Block
        if(!empty($params['project_ids']) AND is_array($params['project_ids']))
          $q->whereIn('project.id',$params['project_ids']);

        if(!empty($params['user_ids']) AND is_array($params['user_ids']))
          $q->whereIn('project.user_id',$params['user_ids']);

        if (!empty($params['tag_ids']) AND is_array($params['tag_ids'])) {
            $q->whereHas('media_tags', function ($q) use ($params) {
                $q->whereIn('project_media_tag.tag_id', $params['tag_ids']);
            });
        }

        if (!empty($params['date'])) {
            $date = $params['date'];
            $q->whereRaw("DATE(project_media.created_at) = '$date'");
        }
        //endregion

        $q->orderBy('project_media.created_at', 'DESC');
        return $q->paginate(12);
    }


    //<editor-fold desc="Relationships">
    public function media_tags(){
        return $this->hasMany('App\Models\ProjectMediaTag','target_id' , 'id')
            ->where('target_type', 'media');
    }
    public function tags_data(){
        return $this->hasMany('App\Models\ProjectMediaTag','target_id' , 'id')
            ->join('tag AS t','t.id','=','project_media_tag.tag_id')
            ->selectRaw('
            project_media_tag.tag_id,
            project_media_tag.qty,
            project_media_tag.target_id,            
            t.name,
            t.spec_type,
            t.build_spec')
            ->where('project_media_tag.target_type', 'media');
    }

    /** this relationship binds with ref_id which is received from app */
    public function media_tags_extended(){
        return $this->hasMany('App\Models\ProjectMediaTag','target_id' , 'ref_id')
            ->where('target_type', 'media');
    }

    /*alias function*/
    public function tags(){
        return $this->media_tags();
    }

    public function category(){
        return $this->belongsTo('App\Models\Category' ,'category_id','id')
            ->selectRaw("id, name, company_id, type, parent_id, min_quantity, thumbnail");
    }
    //</editor-fold>
}
