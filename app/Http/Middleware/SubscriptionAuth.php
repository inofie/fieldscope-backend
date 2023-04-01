<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\CompanySubscriptionRelation;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Lang;

class SubscriptionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $obj = new Controller();
        $obj->call_mode; // call mode for admin ..

        if (in_array($obj->call_mode, ['api'])) {
            if (empty($request->header('user-token'))) {
                $code = 403;
                $response = ['code' => $code, //    'success' => false,
                    'message' => Lang::get('passwords.user_token'), 'data' => [['auth' => Lang::get('passwords.user_token')]],];
                return response()->json($response, $code);
            }
        }

        if( (CompanySubscriptionRelation::hasValidSubscription($request['company_id']) AND !empty($request['company_id']))
            OR (User::subscriptionAuthByToken($request->header('user-token')) AND !empty($request->header('user-token')))
        ) {
            /** Not expired */
        }else {
            /** expired */
            if(in_array($obj->call_mode,['admin', 'web'])){
                return redirect('/subadmin/re_subscription')->with('message','Your subscription has expired. Please Resubscribe.');
            }else{
                $code = 404;
                $response = [
                    'code' => $code,
                    //    'success' => false,
                    'message' => "Your subscription is expired.",
                    'data' => [['subscription' => "Your subscription is expired."]],
                ];
                return response()->json($response, $code);
            }
        }
        return $next($request);
    }
}
