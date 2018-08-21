<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
  protected $table='t_stream';
  protected $primaryKey='STREAM_ID';
  public $timestamps=false;
}
