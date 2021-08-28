<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;

class HomeController extends Controller
{
  use HelperFunction;

  private $module_view = 'frontend.modules';

  public function index()
  {
    $module_view    = $this->module_view . '.home';
    $getUserDetail  = Users::getDetail();

    $data = [
      'title_page'    => 'Home',
      'getUserDetail' => $getUserDetail,
    ];

    return $this->responseView( $module_view, $data );
  }
}
