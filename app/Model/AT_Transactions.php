<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AT_Transactions extends Model
{
  public $timestamps    = false;
  public $incrementing  = false;
  protected $primaryKey = null;
  protected $table      = 'at_transaction';
}
