<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Lang;

class AdminAuthorize
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
        $user = \Session::get('user');
//        dd($user);
        if($user['user_group_id'] != 1){
            $request->session()->flush();
            return redirect('/');
        }

        return $next($request);
    }
}
