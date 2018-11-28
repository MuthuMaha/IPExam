<?php

namespace App\BaseModels;
use DB;
// use App\BaseModels\Student;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    //
     protected $exam_id;
        protected $table = 't_campus';
    	protected $primaryKey = 'CAMPUS_ID';
    public function section()
    {
        return $this->hasMany('App\BaseModels\Section','CAMPUS_ID', 'CAMPUS_ID')
                    ->join('t_course_track as c','c.COURSE_TRACK_ID','t_college_section.COURSE_TRACK_ID')
                    // ->join('t_student as st','st.SECTION_ID','t_college_section.SECTION_ID')
                    ->whereExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                  ->from('t_student')
                                  ->where('t_student.SECTION_ID','=',' t_college_section.SECTION_ID')
                                   ->where('t_college_section.section_name','<>','NOT_ALLOTTED')
                                   ->where('t_college_section.section_name','<>','');
                        })
                   
                    
                    ->orderby('t_college_section.SECTION_ID','ASC');
                    // ->join('t_student as d','d.SECTION_ID','t_college_section.SECTION_ID');
                    // ->where('SECTION_ID', '=', \App\BaseModels\Student::select('SECTION_ID'));
                    // where('email', '=', Input::get('email'))->first()
                    // ->join('IP_Campus_Uploads as b','b.section_id','t_college_section.SECTION_ID');
                    // ->where('STATUS','=','1');
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
    public function check()
    {
        return $this->hasMany('App\Campusupload','CAMPUS_ID','CAMPUS_ID');
    }

}
