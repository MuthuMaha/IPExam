<?php

namespace Illuminate\Hashing;
use App\Employee;
use App\BaseModels\Student;
use App\Tparent;
abstract class AbstractHasher
{
    /**
     * Get information about the given hashed value.
     *
     * @param  string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {

     $user = Employee::where('PASS_WORD',md5($value))->first();
     if(!$user){
        $user = Student::where('PASS_WORD',md5($value))->first();
        if(!$user){
          $user = Tparent::where('PASS_WORD',md5($value))->first();
         
        }
     }
        return $user ? true : false;
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return password_verify($value, $hashedValue);
    }
}
