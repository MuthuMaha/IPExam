<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
        protected $table = 't_district';
    	protected $primaryKey = 'DISTRICT_ID';
    public function section()
    {
        return $this->hasMany('App\BaseModels\Section','CAMPUS_ID', 'CAMPUS_ID');
    }
    
}
