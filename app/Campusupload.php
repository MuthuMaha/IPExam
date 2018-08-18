<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campusupload extends Model
{
   protected $table='IP_Campus_Uploads';
   protected $primaryKey='CAMPUS_ID';
   protected $fillable=['CAMPUS_ID', 'exam_id', 'section_id', 'status'];
   public $timestamps=false;
}
