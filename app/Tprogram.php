<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tprogram extends Model
{
  protected $table='t_program_name';
  protected $primaryKey='PROGRAM_ID';
  public $timestamps=false;
}
