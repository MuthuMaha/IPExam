<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Employee;
use App\Parent_details;
use App\Student;
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
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()                                     
    {

         return new EmployeeCollection(Employee::orderBy('EMPLOYEE_ID','desc')->limit(50)->paginate(10));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function createfile(Request $request)
    {
        $contents=$request->get('content');
        $file=File::put('/var/www/html/omr/public/images/'.time().'.txt',$contents);
        if($file){
            return "file uploaded successfully";
        }
        else{
            return "file not created";
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->hasFile('images')) 
      {
        ini_set('memory_limit','256M');
        $file = $request->file('images');
        $size = $request->file('images')->getClientSize();
        $check=$file->getClientOriginalExtension();
        if($check=='dat' || $check=='iit')
        {
        $input=time().'.'.$file->getClientOriginalExtension();
        $request->file('images')->move('/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads', $input);
    
            return [
                            'success' => ['Image_Uploaded'=> '/sri_chaitanya/College/3_view_created_exam/uploads/'.$input,
                                            'size'=>$size],
                            
                            
                        ];
                    }
                    else{
                         return ['error'=>['Message'=>'Only .dat and .iit is acceptable']];
                    }
        }
        else{
            return ['error'=>['Message'=>'Error While uploading']];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    } 

    public function check(Request $request){

       if (Auth::check())
{
    $id = Auth::user()->SURNAME;

}
         return $id;
    }

     public function empshow(Request $request)
    {
           
        $msg="This is old token";
        if($request->user_type=="employee")
        {
        Auth::attempt([ 'PAYROLL_ID' => $request->get('PAYROLL_ID'), 'password' => $request->get('PASS_WORD') ]);
        }
        if($request->user_type=="student")
        {
        Auth::guard('t_student')->attempt([ 'ADM_NO' => $request->get('ADM_NO'), 'password' => $request->get('PASS_WORD') ]);
        }
        if($request->user_type=="parent")
        {
        Auth::guard('tparent')->attempt([ 'MOBILE_NO' => $request->get('MOBILE_NO'), 'password' => $request->get('PASS_WORD') ]);
        }
        if(Auth::id() || Auth::guard('t_student')->id()|| Auth::guard('tparent')->id()){
            // here im getting the campus_id
            $campus_id="54";
            // Here Im getting the role for this particular ID
            // $role = DB::select('SELECT roles.role FROM `roles` INNER Join user_roles on roles.roll_id=user_roles.ROLL_ID inner join users on users.payroll_id=user_roles.payroll_id WHERE users.id="'.Auth::id().'"');
            // $role="";
                       $exam=DB::select('select ea.test_code,ea.start_date,ea.last_date_to_upload,ea.last_time_to_upload,ea.sl from 1_exam_admin_create_exam as ea where  ea.STATE_ID in (select c.state_id from t_employee as e,t_campus as c where c.campus_id=e.campus_id and c.campus_id="54")');
            if(Auth::id()){
            $role=DB::table('roles')
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::id())
                  ->select('roles.role')
                  ->get();
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
                            ],
                            'Token'=>$token->access_token,
                    ];
         
            }
        }
                  elseif(Auth::guard('t_student')->id()){
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
                            ],
                            'Token'=>$token->access_token,
                    ];
         
            }
           }
           else{
            $student=Parent_details::where('id',Auth::guard('tparent')->id());
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
                            ],
                            'Token'=>$token->access_token,
                          
                    ];
         
            }
           }
                       // fetching exam details of logged in branch from t_
                       // $exam= "";
                       // $exam=DB::table('1_exam_admin_create_exam as ea','t_employee as e','t_campus as c')
                                
            // fetching the token for particular ID

            // Here Im getting the user data
            
            
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Token'=>$token[0],
                        'Students'=>Auth::guard('tparent')->user()->ADM_NO, 
                    ];
        }
        else{
                return [
                        'Login' => [
                            'response_message'=>"error",
                            'response_code'=>"0",
                            ],
                    ];
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function filedownload(Request $request){
          $msg="This is old token";
        Auth::attempt([ 'payroll_id' => $request->get('payroll_id'), 'password' => $request->get('password') ]);
        if(Auth::id()){

            $token=Token::whereUser_id(Auth::id())->pluck('access_token');
            //Here Im getting the user data
            $client = User::find(Auth::id());
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
                        'success' => ['token'=>$token->access_token,'Message'=>$msg],
                        
                        'EMP_ID'=>Auth::id(),
                        'EMP_Name'=>Auth::user()->name,
                        'CAMPUS_ID'=>'54',
                        'SUBJECT'=>'MATHS',
                        'IMAGE_URL'=>'/omr/public/images/3.jpg',
                        
                    ];
         
            }
            
                return [
                    'success' => ['token'=>$token,'Message'=>$msg],
                    'EMP_ID'=>Auth::id(),
                    'EMP_Name'=>Auth::user()->name,
                    'CAMPUS_ID'=>'54',
                    'SUBJECT'=>'MATHS',
                    'IMAGE_URL'=>'/omr/public/images/3.jpg',
                ];
        }
        else{
            return [
                    'error' => ['message'=>'email or password incorrect'],
                ];
        }
    }
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
