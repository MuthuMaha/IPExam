<?php

namespace App;
use App\Employee;
use App\BaseModels\Student;
use App\Tparent;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable=['user_id','expiry_time','access_token'];

    	public function user () {
		return $this->belongsTo(Employee::class, 'user_id', 'EMPLOYEE_ID');
	}	
	public function student () {
		return $this->belongsTo(Student::class, 'user_id', 'ADM_NO');
	}
	public function parent () {
		return $this->belongsTo(Tparent::class, 'user_id', 'MOBILE_NO');
	}
}
