<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;

class Users extends Model
{
  use HelperFunction;

  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_users';
  protected $hidden     = ['password'];

  public static function getAll( $keywords = '', $user_type = 'user' )
  {
    $model = self::where(function( $query ) use ( $keywords ) {
      if( ! empty( $keywords ) )
      {
        $query->where( 'nama', 'like', '%' . $keywords . '%' )
        ->orWhere('email', 'like', '%' . $keywords . '%');
      }
    })
    ->where('roles', $user_type)
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return $model;
  }

  public static function checkEmailExist( $email, $roles = 'user', $user_id = null )
  {
    return self::where(function( $query ) use ( $email, $user_id, $roles ) {
      if( ! empty( $user_id ) )
      {
        $query->where([
          ['email', $email],
          ['roles', $roles],
          ['id', '!=', $user_id]
        ]);
      }
      else
      {
        $query->where([
          ['email', $email],
          ['roles', $roles]
        ]);
      }
    })
    ->first();
  }

  public static function checkCredential( $plain, $hash )
  {
    $check_hash = self::checkHash( $plain, $hash );
    return $check_hash;
  }

  public static function getDetail( $user_id = null )
  {
    if( empty( $user_id ) )
    {
      if( Session::has('user_detail') )
      {
        $get_user = Session::get('user_detail');
        $user_id  = $get_user['id'];
      }
    }

    $result = self::where('id', $user_id)->first();
    return $result;
  }
}
