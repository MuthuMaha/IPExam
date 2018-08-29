<?php

namespace App\BaseModels;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Token;

class Student extends Authenticatable
{
    //
    
    use Notifiable;
    protected $table = 't_student';
    protected $primaryKey = 'ADM_NO';
    private static $test_types=[];

     public function program()
    {
        return $this->hasOne('App\BaseModels\Program','PROGRAM_ID', 'PROGRAM_ID');
    }
     public function parent()
    {
        return $this->hasOne('App\BaseModels\Parents','ADM_NO', 'ADM_NO');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

     public function tokens() {
        return $this->hasMany(Token::class, 'user_id', 'ADM_NO');
    }
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

    	return static::where('ADM_NO','=',$stud_id)->with('program','stream','class_year','campus','section','parent')->get();

    }


    public static function written_tests($stud_id){

        
        //Send all the tests written by student with respect to the examtypes (UT,Final,Pre Final..etc)
    	$test_types=DB::table('0_test_types')->get();
        foreach($test_types as $value){
            
		  $query[$value->test_type_name] = DB::select("select ipd.Exam_name,ipd.Exam_id,ipd.Test_type_id,ecf.group_id,ecf.stream_id,ecf.classyear_id,ecf.program_id from IP_Exam_Details ipd left join IP_Exam_Conducted_For ecf on ipd.exam_id=ecf.Exam_id inner join (select t.CAMPUS_ID,ct.GROUP_ID,pn.PROGRAM_ID,t.class_id,ts.STREAM_ID from t_student t left join t_course_track ct on t.COURSE_TRACK_ID=ct.COURSE_TRACK_ID left join t_study_class sc on sc.class_id=t.class_id left join t_program_name pn on t.PROGRAM_ID=pn.PROGRAM_ID left join t_stream ts on ts.STREAM_ID=t.stream_id WHERE t.adm_no='".$stud_id."') ds on ecf.classyear_id=ds.class_id and ecf.stream_id=ds.stream_id and ecf.program_id=ds.program_id and ecf.exam_id=ipd.exam_id and ds.group_id = ecf.group_id and ipd.Test_type_id='".$value->test_type_id."'"
		            );   
		}
 
        return $query;

    }




}
