<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class DashboardController extends Controller
{
  use HelperFunction;

  private $module_view = 'backoffice.modules';

  public function index()
  {
    $module_view    = $this->module_view . '.dashboard';
    $getUserDetail  = Users::getDetail();

    $data = [
      'title_page'    => 'Dashboard',
      'getUserDetail' => $getUserDetail,
    ];

    return $this->responseView( $module_view, $data );
  }
}
