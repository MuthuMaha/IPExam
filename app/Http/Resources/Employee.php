<?php

namespace App\Http\Resources;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $SUBJECT=DB::table('IP_Exam_Section as a')
                    ->join('0_subjects as b','b.subject_id','=','a.subject_id')
                    ->where('a.EMPLOYEE_ID',$this[0]->PAYROLL_ID)
                    ->select('b.subject_name')
                    ->distinct()
                    ->get();
        return [
            'SURNAME' => $this[0]->SURNAME,
            'USERNAME' => $this[0]->USERNAME,
            'DESIGNATION' => $this[0]->DESIGNATION,
            'SUBJECT' => $SUBJECT,
            'DEPARTMENT'=>$this[0]->SUBJECT,
            'PAYROLL_ID' => $this[0]->PAYROLL_ID,
            'CAMPUSNAME' => $this[0]->CAMPUS_NAME,
            'CAMPUS_ID' => $this[0]->CAMPUS_ID,
        ];
    }

   
}
