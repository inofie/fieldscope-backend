<?php

namespace App\Models;

//use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Libraries\Helper;
use App\Traits\GeneralModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class User extends Model
{
    protected $table = "user";

    protected  $dates = ['created_at','updated_at','deleted_at'];

    use SoftDeletes,GeneralModelTrait
        ;

    public static function createAgent($user)
    {
        $obj = new static();
        //print_r($user);exit;
        $name = explode(' ', $user['name']);

        $obj->first_name = $name[0];
        $obj->last_name = isset($name[1]) ? $name[1] : '';
        $obj->email = $user['email'];
        $obj->image_url = $user['system_image_url'];
        $obj->date_of_join = $user['date_of_join'];
        $obj->mobile_no = $user['mobile_no'];
        /*$obj->age           = $user['age'];
        $obj->gender        = $user['gender'];*/
        $obj->password = $user['password'];
        $obj->user_group_id = 2;
        $obj->company_id = $user['company_id'];
        $obj->token = self::getToken();
        /*$obj->device_type   = $user['device_type'];
        $obj->device_token  = $user['device_token'];
        $obj->device        = $user['device'];*/

        $obj->save();

        return $obj->id;
    }

    public static function createBusiness($user)
    {

        $obj = new static();

        $name = explode(' ', $user['name']);

        $obj->first_name = $name[0];
        $obj->last_name = isset($name[1]) ? $name[1] : '';
        $obj->email = $user['email'];
        $obj->password = $user['password'];
        $obj->image_url = $user['system_image_url'];

        $obj->user_group_id = 1;

        $obj->city = $user['city'];
        $obj->state = $user['state'];

        $obj->website = $user['website'];
        $obj->about_me = $user['description'];

        $obj->token = self::getToken();
        $obj->device_type = $user['device_type'];
        $obj->device_token = $user['device_token'];
        $obj->device = $user['device'];
        $obj->address = $user['address'];

        $obj->save();

        return $obj->id;
    }

    public static function createAccount($request)
    {
        // dd($request);
        $companyObj = new Company();
        $userObj = new User();

        $companyGroupId = $request['company_group_id'];

        if(empty($companyGroupId)){
            /*client admin*/
            $companyObj->title = $request['name'];
            $companyObj->image_url = $request['system_image_url'];
        }else{
            /*non admin*/
            $userObj->company_group_id = $companyGroupId;
            $userObj->company_id = $request['company_id'];
        }

        $nameExploded = explode(' ', $request['name']);

        if(isset($nameExploded[1])){
            $userObj->first_name = $nameExploded[0];

            /*Removing first index */
            array_splice($nameExploded, 0, 1);
            $lastName = implode(' ', $nameExploded);
            $userObj->last_name = $lastName;
        }else{
            $userObj->first_name = $request['name'];
            $userObj->last_name = "";
        }
//        echo"<br>"; print_r($lastName ); die;

        $userObj->image_url = $request['system_image_url'];
        $userObj->email = $request['email'];
        $userObj->password = $request['password'];
        $userObj->mobile_no = $request['mobile_no'];
        $userObj->device_type = $request['device_type'];
        $userObj->device_token = $request['device_token'];
        $userObj->device = $request['device'];
        $userObj->user_group_id = !empty($request['user_group_id']) ?  $request['user_group_id'] : 1;
        $userObj->token = self::getToken();

        if(empty($companyGroupId)){

            \DB::transaction(function () use ($companyObj, $userObj) {

                $companyObj->save();

                $userObj->user_group_id = 0;
                $userObj->company_id = $companyObj->id;
                $userObj->save();

                $companyObj->primary_user_id = $userObj->id;
                $companyObj->save();
            });
        }else{
            $userObj->save();
        }
        return $userObj->id;
    }

    public static function createUserSetting($user_id)
    {
        \DB::statement("INSERT INTO user_setting (SELECT id, $user_id, `value`, NOW(), NOW() FROM setting
                        WHERE key_type = 'user')");
        return true;
    }

    public static function getUserSetting($user_id)
    {
        $query = \DB::table('user_setting');
        $query->select('user_setting.*', 'setting.key');
        $query->leftJoin('setting', 'setting.id', 'user_setting.setting_id');
        $query->where('user_id', $user_id);
        return $query->get();
    }

    public static function updateUserSetting($params)
    {
        $qry_params = [];

        $user_id = $params['user_id'];
        $setting_id = $params['setting_id'];
        $value = $params['value'];


        foreach ($params as $column => $row) {
            $qry_params[] = " $column = '$row' ";
        }

        \DB::statement("UPDATE user_setting SET value = $value WHERE user_id = $user_id AND setting_id = $setting_id");
        return true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name', 'email', 'password',
    ];*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/

    public static function getToken()
    {
        return md5(Config::get('constants.APP_SALT') . time());
    }

    public static function getById($id)
    {
        $query = self::select()->with(['companyGroup']);
        return $query->where('id', $id)
            ->first();
    }

    public static function getCompany($id = NULL,$paginate = NULL)
    {

        $query = self::select();
        $query->join('company', 'company.id', 'user.company_id')
            ->select(
                'user.id',
                'company.title',
                'company.primary_user_id',
                'company.image_url',
                'company.website',
                'company.description',
                'user.email',
                'user.mobile_no',
                'user.company_id',
                'user.token',
                'user.user_group_id',
                'user.device_type',
                'user.device_token',
                'user.device',
                'user.created_at'
            );

        if (!empty($id)) {
            $query->where('user.id', $id);
            //echo "ID"; die;
            return $query->first();
        }
        else if ($paginate){
            return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
        }
        else{
            return $query->get();
        }

    }

    public static function getByDeviceToken($device_token)
    {

        $query = self::select();
        return $query->where('device_token', $device_token)
            ->limit(1)
            ->get();
    }

    public static function getByEmail($email)
    {

        $query = self::select();
        return $query->where('email', $email)
            ->limit(1)
            ->get();
    }

    public static function getBySocial($params)
    {

        $query = self::select();
        return $query->where('social_id', $params['social_id'])
            ->where('social_type', $params['social_type'])
            ->whereNull('deleted_at')
            ->get();
    }

    public static function getByPasswordHash($hash)
    {

        $query = self::select();
        return $query->where('forgot_password_hash', $hash)
            ->get();
    }

    public static function auth($token)
    {
        if (empty($token))
            return false;

        $query = self::select();
        $result = $query->whereRaw("token = '$token'")
            ->whereNull('deleted_at')
            ->first();

        if (!is_null($result) && $result->count())
            return $result;

        return false;
    }

    public static function subscriptionAuthByToken($token)
    {

        if (empty($token)) return 'invalid';

        $query = self::select();
        $query->join('company_subscription_relation AS csr','csr.company_id','=','user.company_id');
        $query->where('csr.subscription_expiry_date' ,'<',date('Y-m-d'));
        $result = $query->whereRaw("user.token = '$token'")->whereNull('user.deleted_at')->first();

        if (!is_null($result) && $result->count())
            return false;

        return true;
    }

    public static function updateByEmail($email, $data)
    {

        $qry_params = [];

        foreach ($data as $column => $row) {
            $qry_params[] = " $column = '$row' ";
        }

        \DB::statement('UPDATE user SET ' . implode(', ', $qry_params) . " WHERE email = '$email'");
        return true;
    }

    public static function login($email, $password)
    {
        $query = self::select();
        return $query->where('email', $email)
            ->where('password', $password)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function loginById($user_id, $password)
    {

        $query = self::select();
        return $query->where('id', $user_id)
            ->where('password', $password)
            ->get();
    }

    public static function getUserList($param)
    {
        $lat = $param['latitude'];
        $lng = $param['longitude'];
        $radius = $param['radius'];

        $haversine = "(3959 * acos (
                    cos ( radians($lat) )
                    * cos( radians(`latitude`) )
                    * cos( radians(`longitude`) - radians($lng) )
                    + sin ( radians($lat) )
                    * sin( radians(`latitude`) )
                ))";


        $query = \DB::table('user');
        $query->select('user.*');

        if (!empty($param['user_group_id']))
            $query->where('user_group_id', $param['user_group_id']);

        if (!empty($param['name'])) {
            $query->whereRaw("((first_name like '%" . $param['name'] . "%' OR last_name like '%" . $param['name'] . "%') OR " .
                "CONCAT(`first_name`, ' ', `last_name`)" . ' LIKE ' . "'%" . $param['name'] . "%')");
        }
        if (!empty($param['latitude']) && !empty($param['longitude']))
            $query->selectRaw("{$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", [$radius]);
        $query->orderBy('id','DESC');
        // HAVING distance < 30 ORDER BY distance

        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getInspectorUserList($param)
    {
        $query = \DB::table('user');
        $query->select('user.*', 'cg.title AS group_title' );
        $query->leftJoin('company_group AS cg','cg.id','user.company_group_id');
        $query->where('user.company_id', $param['company_id']);
        $query->where('user.user_group_id', $param['user_group_id']);
        $query->whereNull('user.deleted_at');
//        $query->where('company_group_id', 2); // agent user group id

        if(!empty($param['keyword']) ){
            $keyword = $param['keyword'];
            $query->where(function ($query) use ($keyword){
                $orWhere =[
                    ['first_name' ,'LIKE',  "%$keyword%"],
                    ['last_name' ,'LIKE',  "%$keyword%"],
                    ['email' ,'LIKE',  "%$keyword%"],
                    ['mobile_no' ,'LIKE',  "%$keyword%"],
                    ['cg.title' ,'LIKE',  "%$keyword%"],
                ];
                foreach ($orWhere AS $item){
                    $query->orWhere([$item]);
                }
            });
        }
        $query->orderBy('user.id','DESC');
        if (!empty($param['name']))
            $query->whereRaw("(first_name like '%" . $param['name'] . "%' OR last_name like '%" . $param['name'] . "%')");

        return $query->paginate(Config::get('constants.PAGINATION_PAGE_SIZE'));
    }

    public static function getUserByIdWithGroup($param)
    {

        $query = \DB::table('user');
        $query->select('user.*','cg.id AS group_id' ,'cg.title AS group_title' );
        $query->leftJoin('company_group AS cg','cg.id','user.company_group_id');
        $query->where('user.company_id', $param['company_id']);
        $query->where('user.id', $param['id']);
        $query->where('user.user_group_id', $param['user_group_id']);
        //$query->where('company_group_id', 2); // agent user group id

//        if(!empty($param['keyword']) ){
//            $keyword = $param['keyword'];
//            $query->where(function ($query) use ($keyword){
//                $orWhere =[
//                    ['first_name'   ,'LIKE',    "%$keyword%"],
//                    ['last_name'    ,'LIKE',    "%$keyword%"],
//                    ['email'        ,'LIKE',    "%$keyword%"],
//                    ['mobile_no'    ,'LIKE',    "%$keyword%"],
//                    ['cg.title'     ,'LIKE',    "%$keyword%"],
//                ];
//                foreach ($orWhere AS $item){
//                    $query->orWhere([$item]);
//                }
//            });
//        }
        return $query->first();
    }

    public static function verifySubscription($user_id, $user_group_id, $subscription_expiry_date)
    {
        if ($user_group_id != 2)
            return 0;

        $date_now = date("Y-m-d");

        if ($date_now <= $subscription_expiry_date)
            return 1;

        \DB::statement("UPDATE user SET user_group_id = 1 WHERE id = $user_id");
        return 0;
    }

    public static function getSubscriptionStatus($user_id)
    {
        $user = self::getById($user_id);

        $user_group_id = ($user[0]['user_group_id']);

        if ($user_group_id != 2)
            return false;

        return true;
    }

    public static function getUserCategories($params){

        /**
         * This query can be removed because required data is coming in $params
         * (Just need to make sure every call of this method provides that data)
         *
         * You can use  CompanyGroupCategory::getCategories if you already have company_id AND company_group_id
         */
        $users = self::where(['company_id' => $params['company_id'], 'id' => $params['user_id'] ])->first()->toArray();

        $catParams = [
            'company_id' => $users['company_id'],
            'company_group_id' => $users['company_group_id'],
            'category_id' => $params['category_id'],
            'sub_category_ids' => $params['sub_category_ids']
        ];

        $params['byType'] = isset($params['byType']) ? $params['byType']: TRUE ;

        $cats = CompanyGroupCategory::getCategories($catParams,$params['byType']);

        return $cats;
    }

    public static function miniObject($user_id)
    {
        $imagePath = env('BASE_URL').Config::get('constants.USER_IMAGE_PATH');
        $query = User::select(\DB::raw("id, first_name, last_name, email, mobile_no,
       IF( image_url IS NOT NULL, CONCAT('$imagePath',image_url ), '' ) AS image_url"))
            ->where('id',$user_id)
            ->first();
        return $query;
    }

    public static function updateFields($fields, $where_clause)
    {
        $field_value = [];
        foreach ($fields as $key => $field) {
            $field_value[] = "$key = '$field'";
        }

        $clause_field_value = [];
        foreach ($where_clause as $key => $field) {
            $clause_field_value[] = "$key = '$field'";
        }

        \DB::statement('Update user set ' . implode(', ', $field_value) . ' WHERE ' . implode(' AND ', $clause_field_value));

        return true;
    }

    public static function updateHoverUsers($hUsers,$request){
        $model = new self();

        foreach ($hUsers['results'] AS $hKey => $hItem ){
            $model::where(['email' => $hItem['email'] , 'company_id' => $request['company_id']])->update(['hover_user_id' => $hItem['id']]);
        }

        return true;
    }

    public static function isNonHoverUser($userId){
        $model = new self();
        return $model::where(['id' => $userId])->whereNull('hover_user_id')->count();
    }

    public static function inspectorDatatable($param){
        $output = [];
        parse_str($param['custom_search'], $output);

//        Helper::p($output,'$output');
//        Helper::pd($param,'$param');

        $query = self::select();

        $query->select('user.id',
            'user.first_name',
            'user.last_name',
            'user.email',
            'user.mobile_no',
            'cg.title AS group_title');

        $query->selectRaw('CONCAT(first_name,\' \',last_name) AS full_name');
        $query->leftJoin('company_group AS cg','cg.id','user.company_group_id');
        $query->where('user.company_id', $param['company_id']);
        $query->where('user.user_group_id', $param['user_group_id']);
        $query->whereNull('user.deleted_at');


        if(!empty($output['keyword']) ){
            $keyword = $output['keyword'];
            $query->where(function ($query) use ($keyword){
                $orWhere =[
                    ['first_name' ,'LIKE',  "%$keyword%"],
                    ['last_name' ,'LIKE',  "%$keyword%"],
                    ['email' ,'LIKE',  "%$keyword%"],
                    ['mobile_no' ,'LIKE',  "%$keyword%"],
                    ['cg.title' ,'LIKE',  "%$keyword%"],
                ];
                foreach ($orWhere AS $item){
                    $query->orWhere([$item]);
                }
            });
        }

        if (!empty($param['name']))
            $query->whereRaw("(first_name like '%" . $param['name'] . "%' OR last_name like '%" . $param['name'] . "%')");


//        $query->groupBy('category.id');


        $sortMap = [
            'full_name',
            'full_name',
            'user.email',
            'user.mobile_no',
            'cg.title'
        ];

        $data['total_record'] = $query->count();

        // \Log::debug('count: '.print_r(['count' => $query->count()],1));

        $param['column_index'] = empty($sortMap[$param['column_index']]) ? 0 : $param['column_index'];
        $query = $query->take($param['length'])->skip($param['start'])
        ->orderByRaw("{$sortMap[$param['column_index']]} {$param['sort']}");

       \Log::debug('sort: '.print_r(['col' => $sortMap[$param['column_index']], 'direction' => $param['sort'] ],1));

        $query = $query->get();
        $data['records'] = $query;
        return $data;
    }

    public static function createCompany($request)
    {
        $result = [];
        $name = Helper::getTwoPartName($request['name']);
        $user = [
            'first_name' => $name['first_name'],
            'last_name' => $name['last_name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'mobile_no' => $request['mobile_no'],
            'user_group_id' => 1,
//            'image_url'     => $request['image'],
            'created_at' => date(config('constants.DATE_FORMAT')),
            'stripe_customer_id' => $request['stripe_customer_id']
        ];

        $date = Carbon::now();

        $sub = $request['plan'];
        if ($sub['duration_unit'] == 'month') {
            $subExpDate = $date->addMonth($sub['duration']);
        } else if ($sub['duration_unit'] == 'year') {
            $subExpDate =  $date->addYear($sub['duration']);
        } else {
            $subExpDate = $date->addDay($sub['duration']);
        }

        $userId = self::insertGetId($user);
        $result['user'] = $userId;

        $company = [
            'title' => $name['first_name'].' '.$name['last_name'],
            'primary_user_id'=> $userId,
            'created_at'     => date(config('constants.DATE_FORMAT')),
        ];

        $companyId = Company::insertGetId($company);
        $result['company'] = $companyId;

        self::where('id',$userId)->update(['company_id' => $companyId]);

        $userSubRel = [
            'company_id' => $companyId,
            'subscription_id'=> $sub['id'],
            'subscription_expiry_date'=> $subExpDate,
            'total_allowed_tiers'=> $sub['total_tiers'],
            'created_at' => date(config('constants.DATE_FORMAT'))
        ];

        $userSubRelId = CompanySubscriptionRelation::insert($userSubRel);
        $result['userSubRel'] =  $userSubRelId;

        return $result;
    }

    public static function countAppUser($param){
        return self::where(['company_id' => $param['company_id'] ])
            ->join('company','company.id','=','user.company_id')
            ->where('company.primary_user_id','<>',\DB::raw('user.id'))
            ->count();
    }

    public function subscribed(){
        return $this->hasMany('App\Models\CompanySubscriptionRelation', 'company_id', 'id');
    }

    public function media()
    {
        return $this->morphMany('App\Models\Media', 'source', 'source_type', 'source_id');
    }

    public function companyGroup()
    {
        return $this->belongsTo('App\Models\CompanyGroup', 'company_group_id', 'id')->selectRaw('id,title,created_at');
    }


}
