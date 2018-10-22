<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipsection extends Model
{
    protected $table='IP_Exam_Section';
    protected $fillable=['id','EMPLOYEE_ID', 'SUBJECT_ID', 'SECTION_ID'];
}
