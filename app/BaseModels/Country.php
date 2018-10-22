<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
        protected $table = 't_city';
    	protected $primaryKey = 'CITY_ID';
    public function section()
    {
        return $this->hasMany('App\BaseModels\Section','CITY_ID', 'CITY_ID');
    }
    
}
