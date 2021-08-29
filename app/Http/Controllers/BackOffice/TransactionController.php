<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;
use App\Model\Transactions;
use App\Model\AT_Transactions;

class TransactionController extends Controller
{
  use HelperFunction;

  private $status_alert   = '';
  private $status_message = 'OK';
  private $module_view    = 'backoffice.modules.transaction';

  public function index( Request $request, $transaction_id = null )
  {
    $getUserDetail  = Users::getDetail();

    if( ! empty( $transaction_id ) )
    {
      $getDetailTransaction = Transactions::getDetail( $transaction_id );
      $getItemTransaction   = AT_Transactions::getAll( $transaction_id );

      if( ! $getDetailTransaction )
      {
        Session::flash('message', 'Transaksi tidak ditemukan.');
        Session::flash('alert', 'error');

        return redirect()->route('frontend.user.transaction.index');
      }

      $module_view    = $this->module_view . '.detail';

      $data = [
        'title_page'            => 'Transaksi ' . $getDetailTransaction->transaction_no,
        'getDetailTransaction'  => $getDetailTransaction,
        'getItemTransaction'    => $getItemTransaction,
      ];
    }
    else
    {
      $keywords       = $request->keywords;
      $start_date     = $request->start_date;
      $end_date       = $request->end_date;

      $module_view    = $this->module_view . '.index';
      $getResult      = Transactions::getAll( $keywords, $start_date, $end_date );

      $data = [
        'title_page'    => 'Daftar Transaksi',
        'getUserDetail' => $getUserDetail,
        'getResult'     => $getResult,
      ];
    }

    return $this->responseView( $module_view, $data );
  }
}
