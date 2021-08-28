<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isRoleAdmin
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
      if( ! Session::has('user_detail') )
      {
        $response = redirect()->route('frontend.login.index');
      }
      else
      {
        $get_user_detail = Session::get('user_detail');

        if( $get_user_detail['roles'] == 'admin' )
        {
          $response = $next( $request );
        }
        else
        {
          $response = redirect()->route('frontend.user.home');
        }
      }

      return $response;
    }
}
