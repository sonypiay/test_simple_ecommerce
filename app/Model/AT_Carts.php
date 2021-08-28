<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AT_Carts extends Model
{
  public $timestamps    = false;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 'at_carts';
}
