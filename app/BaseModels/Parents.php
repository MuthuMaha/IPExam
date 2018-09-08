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
    public static function profile_details($data){
        
        if($data->user_type=="student"){
        $result=new ProfileResource(Student::profile($data->USERID));
         return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Details'=>$result,
                ];
            }
        if($data->user_type=="parent"){
        $result=new ProfileResource(Student::profile($data->USERID));
         return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Details'=>$result,
                ];
            }
        if($data->user_type=="employee"){
         $result=new EmployeeResource(Employee::profile($data->USERID));

          return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Details'=>$result,
                    ];
    }
}
}