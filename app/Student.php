<?php

namespace App;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use App\Token;
class Student extends Authenticatable
{
    use Notifiable;
     protected $table='scaitsqb.t_student_bio';
     protected $guard = 'scaitsqb.t_student_bio';
    //  protected $fillable = [
    //     'name', 'email', 'payroll_id','password','description',
    // ];
     protected $primaryKey='ADM_NO';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps=false;
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
     public function roles()
    {
        return $this->belongsToMany('App\role');
    }

   public function tokens() {
        return $this->hasMany(Token::class, 'user_id', 'ADM_NO');
    }
     

}
