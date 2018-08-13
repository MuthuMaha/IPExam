<?php

namespace App;
use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable=['user_id','expiry_time','access_token'];

 //    	public function user () {
	// 	return $this->belongsTo(Employee::class, 'user_id', 'EMPLOYEE_ID');
	// }
}
