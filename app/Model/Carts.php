<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_carts';
}
