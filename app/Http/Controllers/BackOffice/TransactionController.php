<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

  public function exportToExcel( Request $request )
  {
    $keywords       = $request->keywords;
    $start_date     = $request->start_date;
    $end_date       = $request->end_date;

    $getResult    = AT_Transactions::exportToExcel( $keywords, $start_date, $end_date );
    $spreadsheet  = new Spreadsheet();
    $sheet        = $spreadsheet->getActiveSheet();
    $sheetCellNum = 2;

    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Nomor Transaksi');
    $sheet->setCellValue('D1', 'Produk');
    $sheet->setCellValue('E1', 'Qty');
    $sheet->setCellValue('F1', 'Harga');
    $sheet->setCellValue('G1', 'Subtotal');

    foreach( $getResult as $index => $data ):
      $sheet->setCellValue('A' . $sheetCellNum, ++$index );
      $sheet->setCellValue('B' . $sheetCellNum, $data->nama );
      $sheet->setCellValue('C' . $sheetCellNum, $data->transaction_id );
      $sheet->setCellValue('D' . $sheetCellNum, $data->product_name );
      $sheet->setCellValue('E' . $sheetCellNum, $data->qty );
      $sheet->setCellValue('F' . $sheetCellNum, $data->price );
      $sheet->setCellValue('G' . $sheetCellNum, $data->subtotal_price );
      $sheetCellNum++;
    endforeach;

    $filename = 'Transaksi-' . date('Ymd') . '-' . time() . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
    header("Content-Disposition: attachment; filename=" . $filename);

    $writer = new Xlsx( $spreadsheet );
    return $writer->save('php://output');
    // return $this->responseJson( $getResult );
  }
}
