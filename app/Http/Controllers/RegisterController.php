<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class RegisterController extends Controller
{
  use HelperFunction;

  private $module_view    = 'frontend';
  private $status_message = '';
  private $status_alert   = '';

  public function index()
  {
    $data = [
      'title_page' => 'Registrasi',
    ];

    return response()->view( $this->module_view . '.register', $data );
  }

  public function doRegister( Request $request )
  {
    $response   = redirect()->route('frontend.register.index');
    $user_id    = $this->generateUuid();
    $nama       = $request->fullname;
    $email      = $request->email;
    $password   = $request->password;
    $roles      = 'user';
    $hash_pass  = $this->makeHash( $password );

    $check_email_exist = Users::checkEmailExist( $email );

    try
    {
      if( $check_email_exist )
      {
        $this->status_message = 'Email <strong>' . $email . '</strong> sudah digunakan. Silakan gunakan email lain.';
        $this->status_alert   = 'error';

        $response = $response->withInput();
      }
      else
      {
        $users = new Users;
        $users->id        = $user_id;
        $users->nama      = $nama;
        $users->email     = $email;
        $users->password  = $hash_pass;
        $users->roles     = $roles;
        $users->save();

        $this->status_message = 'Registrasi berhasil.';
        $this->status_alert   = 'success';
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
}
