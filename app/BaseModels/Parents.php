<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    //
    protected $table = 't_parent_details';
    protected $primaryKey = 'ROW_ID';
     public function campus()
    {
        return $this->hasOne('App\BaseModels\Student','ADM_NO', 'ADM_NO');
    }

     public static function profile($parent_id){

        return static::where('ADM_NO','=',$parent_id)->with('campus')->get();

    }
}
