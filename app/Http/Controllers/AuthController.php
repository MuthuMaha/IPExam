<?php 
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Employee;
use App\Campus;
use App\Token;
use App\Exam;
use App\Modesyear;
use App\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\TemplateCollection;
use Illuminate\Support\Facades\Hash;
use File;

use App\Http\Resources\Employee as UserResource;

class AuthController extends Controller
{
    public function tokenAuthCheck (Request $request) {
        $msg="This is old token";
        if(Auth::id()){
              $role=DB::table('roles')
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::id())
                  ->select('roles.role')
                  ->get();
            for($i=0;$i<=sizeof($role)-1;$i++){
                $rolearray[]=$role[$i]->role;
            }
            $token=Token::whereUser_id(Auth::id())->get();
            if($role[0]->role!='EXAM_ADMIN'){
              $exam=new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ->whereRaw('campus_id ='.Auth::user()->CAMPUS_ID);
                                })->paginate());
            }
            else{
                 $exam=new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ;
                                })->paginate());
            }
            $campus="";
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
                        'Exam'=>$exam,
                    ];
             
            }
             
                return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Exam'=>$exam,
                    ];
            }
        
    } 

    public function templateDelete (Request $request) {
        
        $templatedelete=Mode::deletetemplate($request->omr_scanning_type,$request->model_years,$request->test_mode_id);
        

        return $templatedelete;

    }
public function gettemplateData (Request $request) {
    $mode=Modesyear::select('model_years')->get();
    $modedata=Mode::select('test_mode_id','test_mode_name')->get();

        return [
            'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
            'Advanced'=>$mode,
            'Non_Advanced'=>$modedata,

            ];

    }

    public function templateData (Request $request) {

            $manage = (array) json_decode($request->template_data);
            $manage1=json_encode($manage);
             if(!$request->template_data){
                    return [
                    'Login' => [
                                'response_message'=>"Template Object is required",
                                'response_code'=>"0"],
                    ];
               }
             $data = json_decode($request->template_data, true);
              if(!$request->hasFile('images')){
                    return [
                    'Login' => [
                                'response_message'=>"Template Image is required",
                                'response_code'=>"0"],
                    ];
               }
             if(!$request->omr_scanning_type){
                    return [
                    'Login' => [
                                'response_message'=>"omr_scanning_type is required",
                                'response_code'=>"0"],
                    ];
             }
             

             if($request->omr_scanning_type=='Advanced'){
                if(!$request->model_years){
                    return [
                    'Login' => [
                                'response_message'=>"model_years is required",
                                'response_code'=>"0"],
                    ];
               }
          
             if ($request->hasFile('images')) 
              {
                ini_set('memory_limit','256M');
                $file = $request->file('images');
                $input=time().'_'.trim($request->model_years, '"').'.'.$file->getClientOriginalExtension();
                $path=public_path()."/images";          
                $request->file('images')->move($path, $input);
             }
                   
            $template= substr($request->template_data, 1, -1);
             \Log::info($template);
              \Log::info(gettype($request->template_data));
             try{
                        $mode=Modesyear::where('model_years',trim($request->model_years, '"'))
                            ->update(['template_data' =>  $request->template_data,'template_path' => "http://localhost:8000/images/".$input]);
                        $modedata=Modesyear::where('model_years',trim($request->model_years, '"'))
                          ->select('template_data')->get();


                return [
                        'Login' => [
                                    'response_message'=>"success",
                                    'response_code'=>"1"
                                ],
                ];

             }catch(Exception $e){

                    return [
                            'Login' => [
                                        'response_message'=>$e->errorMessage(),
                                        'response_code'=>"0"],
                    ];

             }
                
         
        }
        elseif($request->omr_scanning_type=='Non-Advanced'){
                $template= substr($request->template_data, 1, -1);
             if ($request->hasFile('images')) 
                {
                    if(!$request->test_mode_id){
                        return [
                        'Login' => [
                                    'response_message'=>"test_mode_id is required",
                                    'response_code'=>"0"],
                        ];
                   }
                    ini_set('memory_limit','256M');
                    $file = $request->file('images');
                    $input=time().'_'.trim($request->test_mode_id, '"').'.'.$file->getClientOriginalExtension();
                    $path=public_path()."/images";          
                    $request->file('images')->move($path, $input);
                }
            
            $mode=Mode::where('test_mode_id',trim($request->test_mode_id, '"'))
          ->update(['template_data' =>  $request->template_data,'template_path' =>"http://localhost:8000/images/".$input]);

          $modedata=Mode::where('test_mode_id',trim($request->test_mode_id, '"'))->select('template_data')
          ->get();
         
            return [
                'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1"],
        ];
        }
        else{
                return [
                'Login' => [
                            'response_message'=>$request->omr_scanning_type,
                            'response_code'=>"1"],
        ];
        }
    }

    public function templatedataDownload (Request $request) 
    {
           $modedata=Modesyear::select('template_data','model_years')
            ->where('template_data', '<>', '', 'and')->get();  
           $modedata2=Mode::select('template_data','test_mode_id')
            ->where('template_data', '<>', '', 'and')->get();

            return [

                'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1"],
                'Template_Advanced'=>$modedata,
                'Template_Non_Advanced'=>$modedata2,
        ];
    }
    public function tokenAuthAttempt (Request $request) {
        $msg="This is old token";
        Auth::attempt([ 'payroll_id' => $request->get('payroll_id'), 'password' => $request->get('password') ]);
        if(Auth::id()){
               $role=DB::table('roles')
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::id())
                  ->select('roles.role')
                  ->get();
            for($i=0;$i<=sizeof($role)-1;$i++){
                $rolearray[]=$role[$i]->role;
            }
            $token=Token::whereUser_id(Auth::id())->get();
            if($role[0]->role!='EXAM_ADMIN'){
              $exam= new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ->whereRaw('campus_id = 54');
                                })->paginate());
            }
            else{
                 $exam= new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ;
                                })->paginate());
            }
            $campus="";
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
                            'token'=>$token->access_token,
                            'Role'=>
                            $rolearray
                            ,
                            'CAMPUS_NAME'=>$campus[0]['CAMPUS_NAME'],
                            'CAMPUS_ID'=>$campus[0]['CAMPUS_ID'],
                        'Designation'=>Auth::user()->DESIGNATION,
                            ],
                    ];
             
            }
                return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'token'=>$token[0]['access_token'],
                            'Role'=>
                            $rolearray
                            ,
                            'CAMPUS_NAME'=>$campus[0]['CAMPUS_NAME'],
                            'CAMPUS_ID'=>$campus[0]['CAMPUS_ID'],
                        'Designation'=>Auth::user()->DESIGNATION,
                            ],
                    ];
            }
            else{
                return [
                        'Login' => [
                            'response_message'=>"payroll_id or password wrong",
                            'response_code'=>"0"],
                    ];
            }
        
    }

    

    public function upload (Request $request) {
        if(!$request->Exam_Id){
            return [
                'Login' => [
                            'response_message'=>"Exam_Id required",
                            'response_code'=>"0"],
        ];
        }
        if(!$request->Campus_Id){
            return [
                'Login' => [
                            'response_message'=>"Campus_Id required",
                            'response_code'=>"0"],
        ];
        }
        $CAMPUS_NAME=Campus::select('CAMPUS_ID','CAMPUS_NAME')->where('CAMPUS_ID','=',$request->Campus_Id)->get();

         if ($request->hasFile('files')) 
          {
            ini_set('memory_limit','256M');
            $file = $request->file('files');
            $size = $request->file('files')->getClientSize();
            $check=$file->getClientOriginalExtension();
            if($check=='dat' || $check=='iit')
            {
            $input=$CAMPUS_NAME[0]['CAMPUS_NAME'].'_'.$request->Exam_Id.'.'.$file->getClientOriginalExtension();
            $input1='temp_'.$CAMPUS_NAME[0]['CAMPUS_ID'].'.'.$file->getClientOriginalExtension();
            $path=public_path().'/'.$request->Exam_Id;
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            File::isDirectory($path.'/first') or File::makeDirectory($path.'/first', 0777, true, true);
            $request->file('files')->move($path.'/first', $input);
            $success = File::copy($path.'/first/'.$input,$path.'/'.$input);
            $success = File::move($path.'/'.$input,$path.'/'.$input1);
            $isupload=Exam::where('sl',$request->Exam_Id)
                ->update(['is_college_id_mobile_uploaded' => 
                DB::raw("CONCAT(is_college_id_mobile_uploaded,',',".$CAMPUS_NAME[0]['CAMPUS_ID'].")")
            ], ['timestamps' => false]
            );

                return [
                    'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Image_Uploaded'=> '/sri_chaitanya/uploads/first/'.$input,
                            'size'=>$size
                            ],
                                
                                
                            ];

                        }
                        else{
                            return [
                'Login' => [
                            'response_message'=>".dat or .iit files are acceptable",
                            'response_code'=>"0"],
        ];
                        }
            }
            else{
                return [
                'Login' => [
                            'response_message'=>"files required",
                            'response_code'=>"0"],
        ];
            }
    }

}
