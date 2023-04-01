<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvProjectReports extends Model
{
    protected $table = "ev_project_reports";

    protected $fillable = [ 'id', 'project_id', 'report_id', 'user_id', 'status_id', 'created_at', 'request_params' ];

    /**
     * status_id :
        Created	    1	The report has just been created and has not yet been worked on.
        InProcess	2	The report is being worked on.
        Pending	    3	The report is waiting for customer response.
        Closed	    4	The report is closed.
        Completed	5	The report has been completed.
     **/

    public $status = [
        '1' => [ 'name' => 'Created',   'description' => 'The report has just been created and has not yet been worked on.' ],
        '2' => ['name' => 'InProcess',  'description' => 'The report is being worked on.'],
        '3' => ['name' => 'Pending',    'description' => 'The report is waiting for customer response.'],
        '4' => ['name' => 'Closed',     'description' => 'The report is closed.'],
        '5' => ['name' => 'Completed',  'description' => 'The report has been completed.'],
    ];

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public function createRecord($request,$response,$order){

        $insert = [
            'project_id'  => !empty($request['project_id']) ? $request['project_id'] : $request['ref_id'],
            'user_id'  => $request['user_id'],
            'report_id' => $response['ReportIds'][0],
            'request_params' => json_encode($order),
            'status_id' => 1,
        ];

        return $this->insert($insert);
    }
}
