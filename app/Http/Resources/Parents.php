<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Parents extends JsonResource
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
            'stud_id' => $this[0]->ADM_NO,
            'PARENT_NAME' => $this[0]->PARENT_NAME,
            'OCCUPATION' => $this[0]->OCCUPATION,
            'CATEGORY' => $this[0]->CATEGORY,
            'RCATEGORY' => $this[0]->RCATEGORY,
            'RELIGION' => $this[0]->RELIGION,
            'COMMUNICATION_ADDRESS' => $this[0]->COMMUNICATION_ADDRESS,
            'PERMANENTADDRESS' => $this[0]->PERMANENTADDRESS,
        ];
    }
}
