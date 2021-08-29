<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\GlobalFunction as HelperFunction;

class Carts extends Model
{
  use HelperFunction;

  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_carts';

  public static function getCart( $id )
  {
    $result = self::select([
      'id AS cart_id',
      'ref_user_id AS user_id',
      'total_price',
      'total_qty'
    ])
    ->where('ref_user_id', $id)
    ->orWhere('id', $id)
    ->first();

    return $result;
  }

  public static function deleteCart( $user_id )
  {
    return self::where('ref_user_id', $user_id)->delete();
  }
}
