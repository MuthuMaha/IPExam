<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $table='t_course_group';
  protected $primaryKey='GROUP_ID';
  public $timestamps=false;
}
