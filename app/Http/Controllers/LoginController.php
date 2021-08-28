<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class LoginController extends Controller
{
  use HelperFunction;

  private $module_view    = 'frontend';
  private $status_message = '';
  private $status_alert   = '';

  public function index()
  {
    if( Session::has('user_detail') )
    {
      $get_user_detail = Session::get('user_detail');

      if( $get_user_detail['roles'] == 'user' )
      {
        $response = redirect()->route('frontend.user.home');
      }
      else
      {
        $response = redirect()->route('backoffice.dashboard');
      }

      return $response;
    }

    $data = [
      'title_page' => 'Login User',
    ];

    return response()->view( $this->module_view . '.login', $data );
  }

  public function doLogin( Request $request )
  {
    $response   = redirect()->route('frontend.login.index');
    $email      = $request->email;
    $password   = $request->password;
    $user_type  = $request->user_type ? $request->user_type : 'admin';

    $get_user_exists = Users::checkEmailExist( $email, $user_type );

    try
    {
      if( ! $get_user_exists )
      {
        $this->status_message = 'Email <strong>' . $email . '</strong> tidak terdaftar';
        $this->status_alert   = 'error';

        $response = $response->withInput();
      }
      else
      {
        $checkCredential = Users::checkCredential( $password, $get_user_exists->password );

        if( $get_user_exists->publish == 'Y'  )
        {
          $this->status_message = 'Akun anda telah dinonaktifkan.';
          $this->status_alert   = 'error';
        }
        else if( $checkCredential === false )
        {
          $this->status_message = 'Password yang anda masukkan salah.';
          $this->status_alert   = 'error';
        }
        else
        {
          Session::put('user_detail', $get_user_exists);

          if( $get_user_exists->roles == 'user' )
          {
            $response = redirect()->route('frontend.user.home');
          }
          else
          {
            $response = redirect()->route('backoffice.dashboard');
          }
        }
      }
    }
    catch (\Exception $e)
    {
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
      $this->status_alert   = 'error';
    }

    Session::flash( 'message', $this->status_message );
    Session::flash( 'alert', $this->status_alert );

    return $response;
  }

  public function doLogout()
  {
    if( Session::has('user_detail') )
    {
      Session::forget('user_detail');
    }

    return redirect()->route('frontend.login.index');
  }
}
