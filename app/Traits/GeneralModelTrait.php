<?php

namespace App\Traits;

use App\Libraries\Helper;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

trait GeneralModelTrait
{

    public static function getById($id,$with = []){
        if(!is_int((int)$id)){
            return ['error' => 'ModelError: Invalid param @getById'];
        }

        $query = self::select();
        if(!empty($with)){
            $query->with($with);
        }
        return $query->where('id', $id)
            ->first();
    }

    public static function getBy(array $where, $with = [],$paginate = FALSE)
    {
        if (!is_array($where)) {
            return ['error' => 'ModelError: Invalid param @getBy'];
        }

        $query = self::select();

        if (!empty($with)) {
            $query->with($with);
        }

//        pd($query->where($where)->exists(),'$query->where($where)->exists()');
        if(!$query->where($where)->exists()){
            return ['error' => 'ModelError: No Record @getBy'];
        }

        if($paginate){
            return $query->where($where)->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }else{
            return $query->where($where)->get();
        }

    }

    public static function updateFields($fields, $where_clause)
    {
        $field_value = [];
        foreach ($fields as $key => $field) {
            $field_value[] = "$key = '$field'";
        }

        $model = new self();
        $clause_field_value = [];
        foreach ($where_clause as $key => $field) {
            $clause_field_value[] = "$key = '$field'";
        }
        $sql = 'Update '.$model->table.' set ' . implode(', ', $field_value) . ' WHERE ' . implode(' AND ', $clause_field_value);
        echo ($model->table);
        die($sql);

        \DB::statement();

        return true;
    }

    public static function customColumn($alias = 0, $paramColumns = [], $prefix = '')
    {
        $table = new self();
        $columns = $table->getTableColumn();
        $parsedCols = [];

        if (count(((array) $columns)) > 0) {
            foreach ($columns as $key => $column) {

                if (!empty($paramColumns) && !in_array($column, $paramColumns)) {
                    continue;
                }

                if ($alias == 1) {
                    $columnAlias = "";
                    if(empty($prefix))
                    {
                        $columnAlias = (strtolower($table->getTable()) . "_" . $column);
                    }
                    else{
                        $columnAlias = ($prefix . "_" . $column);
                    }

                    $parsedCols[$key] = strtolower($table->getTable()) . "." . $column . " AS " . $columnAlias;
                } else {
                    $parsedCols[$key] = strtolower($table->getTable()) . "." . $column;
                }
            }
        }
        return $parsedCols;
    }


    /** Use to revert back already parsed custom column names back for resource **/
    public static function getColumnData($data,$full = true)
    {
        $table = new self();
        $colums = $table->getTableColumn();

        $response = [];
        if(count(((array) $colums)) > 0){
            foreach ($colums as $key => $colum){
                $col = strtolower($table->getTable())."_".$colum;
                $response[$colum] = $data[$col];
            }
        }

        return $response;
    }

    public function getTableColumn()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /************** Relationship Sample ******************/
//    public function ManyToManyExample()
//    {
//        return $this->belongsToMany('other_table_model','pivot_table','this_model_key_in_pivot_table','related_model_key_in_pivot_table');
//    }
//
//    public function polyMorphParentTableExample()
//    {
//        return $this->morphMany('App\Models\Review', 'reviewable' , 'module','module_id');
//    }
//
//    public function polyMorphChildTableExample()
//    {
//        return $this->morphTo('reviewable','module','module_id');
//    }


    /*$column = to compare for uniquesness*/
    public static function make_unique ($column, $string = null){

        //        Another way of making token  - bin2hex(random_bytes(32))

        $randString = mt_rand(123456,99999999999);
        $token = ($string.'-'.$randString);
        while(self::where($column,$token)->exists()){
            $randString = mt_rand(123456,99999999999);
            $token = ($string.'-'.$randString);
        }
        return $token;
    }

    public static function make_hash($string){
        return md5(config('constants.APP_SALT') . $string);
    }

    public static function sendMail($identifier, $to, $params)
    {
        $template = MailTemplate::getByIdentifier($identifier);

        $mail_subject = $template->subject;
        $mail_body = $template->body;
        $mail_wildcards = explode(',', $template->wildcards);
        $to = trim($to);
        $from = trim($template->from);
        if(empty($from))
            $from = Setting::getByKey('send_email')->value;


        $mail_wildcard_values = [];
        foreach($mail_wildcards as $value) {
            $value = str_replace(['[',']'],'', $value);
            $mail_wildcard_values[] = $params[$value];
        }

        $mail_body = str_replace($mail_wildcards, $mail_wildcard_values, $mail_body);
//        $headers = "From: $from" . "\r\n" ;
        //$headers .= "CC: $cc";

        try {
            //$from = env('MAIL_USERNAME');
//            die(env('MAIL_FROM_ADDRESS'));
            Mail::send('emails.default_template', ['content' => $mail_body], function ($m) use ($to, $from, $mail_subject) {
                $m->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $m->to($to)->subject($mail_subject);
            });
        }catch (\Exception $e){
            print $e->getMessage();
            die('exception');
//            $headers .= "Content-Type: text/html";
//            mail($to, $mail_subject, $mail_body, $headers);
        }

        return true;
    }
}