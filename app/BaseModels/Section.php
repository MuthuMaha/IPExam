<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
     //
    protected $table = 't_college_section';
    protected $primaryKey = 'SECTION_ID';

     public function campus()
    {
        return $this->hasOne('App\BaseModels\Campus','CAMPUS_ID', 'CAMPUS_ID');
    }  
}
