<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
  public $timestamps    = true;
  public $incrementing  = false;
  protected $primaryKey = 'id';
  protected $table      = 't_users';
}
