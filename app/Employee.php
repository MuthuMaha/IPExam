<?php

namespace App;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;
use App\Http\Requests\LoginValidation;
use Carbon\Carbon;
use App\Employee;
use App\Parent_details;
use App\BaseModels\Student;
use App\BaseModels\Campus;
use App\Tparent;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use App\Exam;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\ExamCollection;
use DB;
use File;
class Employee extends Authenticatable
{
    use Notifiable;
     protected $table='t_employee';

    //  protected $fillable = [
    //     'name', 'email', 'payroll_id','password','description',
    // ];
     protected $primaryKey='EMPLOYEE_ID';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps=false;
    protected $hidden = [
        'password', 'remember_token',
    ];
     public function roles()
    {
        return $this->belongsToMany('App\role');
    }

   public function tokens() {
        return $this->hasMany(Token::class, 'user_id', 'EMPLOYEE_ID');
    }
     
     public function campus()
    {
        return $this->hasOne('App\BaseModels\Campus','CAMPUS_ID', 'CAMPUS_ID');
    }

     public static function profile($employee_id){

        return static::where('PAYROLL_ID','=',$employee_id)->with('campus')->get();

    }

    public static function login($data){
        //Change the driver based on usertype
          $msg="This is old token";
        if($data->user_type=="employee")
        {
        Auth::attempt([ 'PAYROLL_ID' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
        if($data->user_type=="student")
        {
        Auth::guard('t_student')->attempt([ 'ADM_NO' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
        if($data->user_type=="parent")
        {
        Auth::guard('tparent')->attempt([ 'ADM_NO' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
      if(Auth::id() || Auth::guard('t_student')->id()|| Auth::guard('tparent')->id()){
         $c=array();
            if(Auth::id()){
                $details=[
                    'USER_NAME'=>Auth::user()->USER_NAME,
                    'SURNAME'=>Auth::user()->SURNAME,
                    'NAME'=>Auth::user()->NAME,
                    'USER'=>'EMPLOYEE',
                    'DESIGNATION'=>Auth::user()->DESIGNATION,
                    'CAMPUS_ID'=>Auth::user()->CAMPUS_ID
                          ];
            $role=DB::table('roles')
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('t_employee','t_employee.payroll_id','=','user_roles.payroll_id')
                  ->where('t_employee.EMPLOYEE_ID','=',Auth::id())
                  ->select('roles.role')
                  ->get();
                     
            // Here Im getting the user data
            foreach ($role as $key => $value) {
               $c[]=$value->role;
            }
            
            $token=Token::whereUser_id(Auth::id())->pluck('access_token');
            $client = Employee::find(Auth::id());
            $uc=$client->tokens()->where('created_at', '<', Carbon::now()->subDay())->delete();
           if($uc){
             $msg='Token expired and New Token generated';
           }
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            'Role'=>$c,
                            ],
                            'Details'=>$details,
                    ];
         
            }
        }
                  elseif(Auth::guard('t_student')->id()){
                $details=[
                    'NAME'=>Auth::guard('t_student')->user()->NAME,
                    'USER_NAME'=>Auth::guard('t_student')->user()->USER_NAME,
                    'SURNAME'=>Auth::guard('t_student')->user()->SURNAME,
                    'USER'=>'STUDENT',
                    'GROUP'=>Auth::guard('t_student')->user()->GROUP_NAME,
                    'SUBJECT'=>Auth::guard('t_student')->user()->SUBJECT,
                    'CAMPUS_ID'=>Auth::guard('t_student')->user()->CAMPUS_ID,
                    'ACADEMIC_YEAR'=>Auth::guard('t_student')->user()->ACADEMIC_YEAR,
                    'YEAR'=>Auth::guard('t_student')->user()->CLASS_ID
                          ];
                       $role=DB::table('roles')
                  
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::guard('t_student')->id())
                  ->select('roles.role')
                  ->get();
                   $token=Token::whereUser_id(Auth::guard('t_student')->id())->pluck('access_token');
                    $client = Student::find(Auth::guard('t_student')->id());
            $uc=$client->tokens()->where('created_at', '<', Carbon::now()->subDay())->delete();
              if($uc){
             $msg='Token expired and New Token generated';
           }
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::guard('t_student')->id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
             
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            ],
                            'Details'=>$details,
                    ];
         
            }
           }
           else{
               
            $student=Parent_details::where('ADM_NO',Auth::guard('tparent')->id())->get();
             $details=[
                    'NAME'=>$student[0]->PARENT_NAME,
                    'USER'=>'PARENT',
                    'STUDENT'=>Auth::guard('tparent')->user()->NAME,
                    'CAMPUS_ID'=>Auth::guard('tparent')->user()->CAMPUS_ID,
                    'YEAR'=>Auth::guard('tparent')->user()->CLASS_ID
                          ];
                $role=DB::table('roles')                  
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::guard('tparent')->id())
                  ->select('roles.role')
                  ->get();
                   $token=Token::whereUser_id(Auth::guard('tparent')->id())->pluck('access_token');
                    $client = Tparent::find(Auth::guard('tparent')->id());
            $uc=$client->tokens()->where('created_at', '<', Carbon::now()->subDay())->delete();
              if($uc){
             $msg='Token expired and New Token generated';
           }
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::guard('tparent')->id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            ],
                            'Details'=>$details,
                          
                    ];
         
            }
           }
                     
           if(Auth::id())
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                        'Token'=>$token[0],
                        'Role'=>$c,
                            ],
                        'Details'=>$details,
                    ];
                    else
                         return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                        'Token'=>$token[0],
                            ],
                        'Details'=>$details, 
                    ];
        }
        else{
                return [
                        'Login' => [
                            'response_message'=>"error",
                            'response_code'=>"0"
                           ],
                    ];
        }

    }
}
