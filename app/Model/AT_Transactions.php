<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AT_Transactions extends Model
{
  public $timestamps    = false;
  public $incrementing  = false;
  protected $primaryKey = null;
  protected $table      = 'at_transactions';

  public static function getAll( $transaction_id )
  {
    $result = self::select([
      'at_transactions.qty as total_qty',
      'at_transactions.price',
      'at_transactions.subtotal_price',
      't_product.id as product_id',
      't_product.product_name',
      't_product.product_image'
    ])
    ->join( 't_product', 'at_transactions.ref_product_id', '=', 't_product.id' )
    ->where('at_transactions.ref_transaction_id', $transaction_id)
    ->get();

    return $result;
  }

  public static function exportToExcel( $keywords = '', $start_date = '', $end_date = '' )
  {
    $result = AT_Transactions::select([
      'at_transactions.qty',
      'at_transactions.price',
      'at_transactions.subtotal_price',
      'at_transactions.sort',
      't_transactions.transaction_id',
      't_transactions.total_qty',
      't_transactions.total_price',
      't_transactions.created_at',
      't_users.nama',
      't_product.id as product_id',
      't_product.product_name'
    ])
    ->join('t_transactions', 'at_transactions.ref_transaction_id', '=', 't_transactions.id')
    ->join('t_users', 't_transactions.ref_user_id', '=', 't_users.id')
    ->join('t_product', 'at_transactions.ref_product_id', '=', 't_product.id');

    if( ! empty( $keywords ) )
    {
      $result = $result->where(function( $query ) use ( $keywords ) {
        $query->where('t_transactions.transaction_id', 'like', '%' . $keywords . '%');
      });
    }

    if( ! empty( $start_date ) AND ! empty( $end_date ) )
    {
      $result = $result->where(function( $query ) use ( $start_date, $end_date ) {
        $query->whereBetween(DB::raw('DATE_FORMAT(t_transactions.created_at, "%Y-%m-%d")'), [$start_date, $end_date]);
      });
    }

    $result = $result
    ->orderBy('t_transactions.created_at', 'asc')
    ->get();

    return $result;
  }
}
