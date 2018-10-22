<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    //
        protected $table = 't_campus';
    	protected $primaryKey = 'CAMPUS_ID';
    public function section()
    {
        return $this->hasMany('App\BaseModels\Section','CAMPUS_ID', 'CAMPUS_ID');
    }

    public function district()
    {
        return $this->hasOne('App\BaseModels\District','DISTRICT_ID', 'DISTRICT_ID');
    }
    public function state()
    {
        return $this->hasOne('App\BaseModels\State','STATE_ID', 'STATE_ID');
    }
    public function city()
    {
        return $this->hasOne('App\BaseModels\City','CITY_ID', 'CITY_ID');
    }

}
