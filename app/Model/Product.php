<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_product';

  public static function getAll( $keywords = '' )
  {
    $params = [
      'keywords'    => $keywords,
    ];

    $model = self::where(function( $query ) use ( $keywords ) {
      if( ! empty( $keywords ) )
      {
        $query->where( 'product_code', 'like', '%' . $keywords . '%' )
        ->orWhere('product_name', 'like', '%' . $keywords . '%');
      }
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10)
    ->appends( $params );

    return $model;
  }

  public static function checkProductCode( $product_code, $product_id = null )
  {
    $check = self::select('product_code')
    ->where(function( $query ) use ( $product_code, $product_id ) {
      if( ! empty( $product_id ) )
      {
        $query->where([
          ['product_code', $product_code],
          ['id', '!=', $product_id]
        ]);
      }
      else
      {
        $query->where('product_code', $product_code);
      }
    })
    ->first();

    return $check ? true : false;
  }
}
