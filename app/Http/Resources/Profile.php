<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            'name' => $this[0]->NAME,
            'group' => $this[0]->GROUP_NAME,
            'stream' => $this[0]->stream->STREAM_NAME,
            'class' => $this[0]->class_year->CLASS_NAME,
            'program' => $this[0]->program->PROGRAM_NAME,
            'campus' => $this[0]->campus->CAMPUS_NAME,
            'section' => $this[0]->section == '' ? null : $this[0]->section->section_name,
            'parent' => $this[0]->parent == '' ? null : $this[0]->parent->PARENT_NAME,
        ];
    }
}
