<?php

namespace App\Http\Resources;

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
        return [
            'SURNAME' => $this[0]->SURNAME,
            'USERNAME' => $this[0]->USERNAME,
            'DESIGNATION' => $this[0]->DESIGNATION,
            'SUBJECT' => $this[0]->SUBJECT,
            'PAYROLL_ID' => $this[0]->PAYROLL_ID,
            'CAMPUSNAME' => $this[0]->CAMPUS_NAME,
            'CAMPUS_ID' => $this[0]->CAMPUS_ID,
        ];
    }

   
}
