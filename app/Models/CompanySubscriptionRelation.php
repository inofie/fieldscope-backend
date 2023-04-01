<?php

namespace App\Models;

use App\Traits\GeneralModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class CompanySubscriptionRelation extends Model
{
    protected $table = "company_subscription_relation";

    use GeneralModelTrait;

    public static function getList($param)
    {
        $query = self::select();

        if (!empty($param['keyword'])) {
            //echo "AAA";die;
            $keyword = $param['keyword'];
//            $query->whereRaw("(`category`.`name` LIKE '%$keyword%' OR `min_quantity` LIKE '%$keyword%')");
            $query->where(function ($where) use ($keyword) {
                $where->orWhere('name', 'LIKE', "'%$keyword%'");
            });
        }
        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getById($id){
        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function hasSubscriptionExpired($companyId){

         if (empty($companyId))  return false;
        $data = self::where(['company_id' => $companyId ])
            ->where('subscription_expiry_date' ,'<',date('Y-m-d'))->count();
        if($data > 0){
            return true;
        }
        return false;
    }

    public static function hasValidSubscription($companyId){

        if (empty($companyId))  return false;
        $data = self::where(['company_id' => $companyId ])
            ->where('subscription_expiry_date' ,'>=',date('Y-m-d'))->count();
        if($data > 0){
            return true;
        }
        return false;
    }

    public static function getByCompanyId($param){
        return self::withSubscription()->where(['company_id' => $param['company_id']])
            ->addSelect('company_subscription_relation.*')
            ->first();
    }

    public static function reSubscribe($params,$sub){

        $date = Carbon::now();

        if ($sub['duration_unit'] == 'month') {
            $subExpDate = $date->addMonth($sub['duration']);
        } else if ($sub['duration_unit'] == 'year') {
            $subExpDate =  $date->addYear($sub['duration']);
        } else {
            $subExpDate = $date->addDay($sub['duration']);
        }

        $userSubRel = [
            'subscription_id'=> $sub['id'],
            'subscription_expiry_date'=> $subExpDate,
            'total_allowed_tiers'=> $sub['allowed_tiers'],
            'updated_at' => date(config('constants.DATE_FORMAT'))
        ];

        return self::where(['company_id' => $params['company_id']])->update($userSubRel);
    }

    public function scopeWithSubscription($q){

        $q->join('subscription','subscription.id',$this->table.'.subscription_id');
        $cols = Subscription::customColumn(1,'','plan');
        $q->addSelect($cols);
    }

    public function subscription(){
        return $this->belongsTo('App\Models\Subscription', 'subscription_id', 'id');
    }

}
