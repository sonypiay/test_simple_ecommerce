<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckUserLogin
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
        $response = redirect()->route('login.index');
      }
      else
      {
        $response = $next( $request );
      }

      return $response;
    }
}
