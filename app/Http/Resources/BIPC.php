<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BIPC extends JsonResource
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
            "PHYSICS"=>$request->PHYICS
          
            ];
    }
}
