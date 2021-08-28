<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class UserController extends Controller
{
  use HelperFunction;

  private $module_view = 'backoffice.modules.users';
  private $status_message;
  private $status_alert;

  public function index( Request $request )
  {
    $keywords     = $request->keywords;
    $user_type    = $request->user_type ? $request->user_type : 'user';
    $module_view  = $this->module_view . '.index';
    $getResult    = Users::getAll( $keywords, $user_type );

    $data = [
      'title_page'  => 'Daftar ' . ucwords( $user_type ),
      'user_type'   => $user_type,
      'getResult'   => $getResult,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function createOrEdit( Request $request, $id = null )
  {
    $getResult    = null;
    $url_action   = route('backoffice.users.store');
    $action_name  = 'store';
    $title_page   = 'Tambah Admin';

    if( ! empty( $id ) )
    {
      $getResult    = Users::findOrFail( $id );
      $action_name  = 'update';
      $url_action   = route('backoffice.users.update', ['id' => $id]);
      $title_page   = 'Edit Admin - ' . $getResult->nama;
    }

    $module_view  = $this->module_view . '.create_edit';

    $data = [
      'title_page'  => $title_page,
      'action_name' => $action_name,
      'url_action'  => $url_action,
      'getResult'   => $getResult,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function storeOrUpdate( Request $request, $id = null )
  {
    $user_id    = $this->generateUuid();
    $nama       = $request->nama;
    $email      = $request->email;
    $password   = $request->password;
    $publish    = $request->publish;
    $roles      = 'admin';

    if( empty( $id ) )
    {
      $response = redirect()->route('backoffice.users.create_page')->withInput();
    }
    else
    {
      $response = redirect()->route('backoffice.users.edit_page', ['id' => $id])->withInput();
    }

    try
    {
      $check_email = Users::checkEmailExist( $email, 'admin', $id );

      if( $check_email === true )
      {
        $this->status_message = 'Email ' . $email . ' sudah terdaftar.';
        $this->status_alert   = 'error';
      }
      else
      {
        if( ! empty( $id ) )
        {
          $model = Users::findOrFail( $id );
        }
        else
        {
          $model = new Users;
          $model->id = $user_id;
        }

        $model->nama      = $nama;
        $model->email     = $email;
        $model->password  = $this->makeHash( $password );
        $model->publish   = $publish;
        $model->save();

        $this->status_message = 'Data berhasil disimpan';
        $this->status_alert   = 'success';

        $response = redirect()->route('backoffice.users.index');
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

  public function destroy( Request $request, $id = null )
  {
    $id = $id === null ? $request->id : $id;

    try
    {
      $getResult  = Users::findOrFail( $id );

      $this->foreignKeyEnable();
      $getResult->delete();
      $this->foreignKeyDisable();

      $this->status_message = 'Data berhasil dihapus';
      $this->status_alert   = 'success';
    }
    catch (\Exception $e)
    {
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
      $this->status_alert   = 'error';
    }

    Session::flash( 'message', $this->status_message );
    Session::flash( 'alert', $this->status_alert );

    return redirect()->route('backoffice.users.index');
  }
}
