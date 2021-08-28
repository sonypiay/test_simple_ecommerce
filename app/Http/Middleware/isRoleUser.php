<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isRoleUser
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

        if( $get_user_detail['roles'] == 'user' )
        {
          $response = $next( $request );
        }
        else
        {
          $response = redirect()->route('backoffice.dashboard');
        }
      }

      return $response;
    }
}
