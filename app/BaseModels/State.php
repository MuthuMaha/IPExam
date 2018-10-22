<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
        protected $table = 't_state';
    	protected $primaryKey = 'STATE_ID';
    public function section()
    {
        return $this->hasMany('App\BaseModels\Section','STATE_ID', 'STATE_ID');
    }
    
}
