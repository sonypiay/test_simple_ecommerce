<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class ProfileController extends Controller
{
  use HelperFunction;

  private $module_view = 'frontend.modules.profile';
  private $status_message;
  private $status_alert;

  public function index()
  {
    $getResult    = Users::getDetail();

    if( ! $getResult ) abort(404);

    $module_view  = $this->module_view . '.index';

    $data = [
      'title_page'  => 'Ubah Profil',
      'getResult'   => $getResult,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function update( Request $request )
  {
    $response = redirect()->route('frontend.user.profile.index');
    $nama     = $request->nama;
    $email    = $request->email;

    try
    {
      $getResult    = Users::getDetail();

      if( ! $getResult )
      {
        $this->status_alert   = 'error';
        $this->status_message = 'Gagal mengubah profil.';
      }
      else
      {
        $check_email  = Users::checkEmailExist( $email, $getResult->roles, $getResult->id );

        if( $check_email )
        {
          $this->status_message = 'Email ' . $email . ' sudah terdaftar.';
          $this->status_alert   = 'error';
        }
        else
        {
          $getResult->nama  = $nama;
          $getResult->email = $email;
          $getResult->save();

          $this->status_message = 'Data berhasil disimpan';
          $this->status_alert   = 'success';
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
}
