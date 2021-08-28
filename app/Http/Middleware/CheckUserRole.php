<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckUserRole
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
      if( Session::has('user_detail') )
      {
        $get_user_detail = Session::get('user_detail');
        if( $get_user_detail['roles'] == 'admin' )
        {
          $response = redirect()->route('backoffice.dashboard');
        }
        else
        {
          $response = redirect()->route('frontend.user.home');  
        }
      }

      return $response;
    }
}
