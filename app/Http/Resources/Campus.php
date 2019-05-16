<?php

namespace App\Http\Resources;
use App\Mode;
use App\Type;
use App\Modesyear;
use Illuminate\Http\Resources\Json\JsonResource;

    // include('status.php');
class Campus extends JsonResource
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
            "groupName"=>$this->CAMPUS_NAME,
            // "CAMPUS_ID"=>$this->CAMPUS_ID,
            "groupData"=>$this->section,
        ];
    }
}
