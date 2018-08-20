<?php

namespace App\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 't_student';
    protected $primaryKey = 'ADM_NO';

     public function program()
    {
        return $this->hasOne('App\BaseModels\Program','PROGRAM_ID', 'PROGRAM_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stream()
    {
        return $this->hasOne('App\BaseModels\Stream','STREAM_ID','STREAM_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function class_year()
    {
        return $this->hasOne('App\BaseModels\StudyClass','CLASS_ID','CLASS_ID');
    }

    public function campus()
    {
        return $this->hasOne('App\BaseModels\Campus','CAMPUS_ID','CAMPUS_ID');
    }

    public function section()
    {
        return $this->hasOne('App\BaseModels\Section','SECTION_ID','SECTION_ID');
    }

    public static function profile($stud_id){

    	return static::where('ADM_NO','=',$stud_id)->with('program','stream','class_year','campus','section')->get();

    }


}
