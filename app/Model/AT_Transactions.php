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
}
