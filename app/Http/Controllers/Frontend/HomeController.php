<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;
use App\Model\Product;

class HomeController extends Controller
{
  use HelperFunction;

  private $module_view = 'frontend.modules';

  public function index( Request $request )
  {
    $keywords = $request->keywords;

    $module_view    = $this->module_view . '.home';
    $getUserDetail  = Users::getDetail();
    $getProduct     = Product::getAll( 'user', $keywords );

    $data = [
      'title_page'    => 'Home',
      'getUserDetail' => $getUserDetail,
      'getProduct'    => $getProduct,
    ];

    return $this->responseView( $module_view, $data );
  }
}
