<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transactions extends Model
{
  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_transactions';

  public static function getAll( $keywords = '', $start_date = '', $end_date = '', $user_id = '' )
  {
    $params = [
      'keywords'    => $keywords,
      'start_date'  => $start_date,
      'end_date'    => $end_date,
    ];

    $result = self::select([
      't_transactions.id AS transaction_id',
      't_transactions.transaction_id AS transaction_no',
      't_transactions.total_price',
      't_transactions.total_qty',
      't_transactions.created_at',
      't_product.id AS product_id',
      't_product.product_name',
      't_product.product_image',
      't_users.id AS user_id',
      't_users.nama'
    ])
    ->join('t_users', 't_transactions.ref_user_id', '=', 't_users.id')
    ->join('at_transactions', 't_transactions.id', '=', 'at_transactions.ref_transaction_id')
    ->join('t_product', 'at_transactions.ref_product_id', '=', 't_product.id');

    if( ! empty( $user_id ) )
    {
      $result = $result->where('t_transactions.ref_user_id', $user_id);
    }

    if( ! empty( $keywords ) )
    {
      $result = $result->where(function( $query ) use ( $keywords, $user_id ) {
        $query->where('t_transactions.transaction_id', 'like', '%' . $keywords . '%')
        ->orWhere([
          ['t_users.nama', 'like', '%' . $keywords . '%'],
          ['t_users.id', '!=', $user_id]
        ]);
      });
    }

    if( ! empty( $start_date ) AND ! empty( $end_date ) )
    {
      $result = $result->where(function( $query ) use ( $start_date, $end_date ) {
        $query->whereBetween(DB::raw('DATE_FORMAT(t_transactions.created_at, "%Y-%m-%d")'), [$start_date, $end_date]);
      });
    }

    $result = $result->groupBy('t_transactions.id')
    ->orderBy('t_transactions.created_at', 'desc')
    ->paginate(10)
    ->appends( $params );

    return $result;
  }

  public static function getDetail( $id )
  {
    $result = self::select([
      't_transactions.id AS transaction_id',
      't_transactions.transaction_id AS transaction_no',
      't_transactions.total_price',
      't_transactions.total_qty',
      't_transactions.created_at'
    ])
    ->where('t_transactions.id', $id)
    ->orWhere('t_transactions.transaction_id', $id)
    ->first();

    return $result;
  }
}
