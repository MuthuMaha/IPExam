<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classyear extends Model
{
  protected $table='t_study_class';
  protected $primaryKey='CLASS_ID';
  public $timestamps=false;
}
