<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipexamconductedfor extends Model
{
   protected $table='IP_Exam_Conducted_For';
   // protected $primaryKey='exam_id';
   protected $fillable=[ 'exam_id', 'group_id', 'classyear_id', 'stream_id', 'program_id'];
   public $timestamps=false;
}
