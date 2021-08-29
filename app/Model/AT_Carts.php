<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AT_Carts extends Model
{
  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 'at_carts';

  public static function getAll( $id )
  {
    $result = self::select([
      'at_carts.id as item_cart_id',
      'at_carts.qty',
      'at_carts.price',
      'at_carts.subtotal_price',
      't_carts.total_price',
      't_carts.total_qty',
      't_product.id AS product_id',
      't_product.product_name',
      't_product.price AS product_price',
      't_product.product_image'
    ])
    ->join('t_carts', 'at_carts.ref_cart_id', '=', 't_carts.id')
    ->join('t_product', 'at_carts.ref_product_id', '=', 't_product.id')
    ->where(function( $query ) use ( $id ) {
      $query->where('t_carts.ref_user_id', $id)
      ->orWhere('t_carts.id', $id);
    })
    ->orderBy('at_carts.created_at', 'desc')
    ->get();

    return $result;
  }

  public static function getDetailItem( $cart_id, $product_id )
  {
    $result = AT_Carts::where([
      ['ref_cart_id', $cart_id],
      ['ref_product_id', $product_id]
    ])
    ->first();

    return $result;
  }
}
