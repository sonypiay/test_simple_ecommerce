<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class ChangePasswordController extends Controller
{
  use HelperFunction;

  private $module_view = 'frontend.modules.change_password';
  private $status_message;
  private $status_alert;

  public function index()
  {
    $getResult    = Users::getDetail();

    if( ! $getResult ) abort(404);

    $module_view  = $this->module_view . '.index';

    $data = [
      'title_page'  => 'Ganti Password',
      'getResult'   => $getResult,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function update( Request $request )
  {
    $response       = redirect()->route('frontend.user.change_password.index');
    $new_password   = $request->new_password;
    $hash_password  = $this->makeHash( $new_password );

    try {
      $getResult = Users::getDetail();

      if( ! $getResult )
      {
        $this->status_alert   = 'error';
        $this->status_message = 'Gagal mengupdate password';
      }
      else
      {
        $getResult->password = $hash_password;
        $getResult->save();

        $this->status_alert   = 'success';
        $this->status_message = 'Berhasil mengganti password';
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
