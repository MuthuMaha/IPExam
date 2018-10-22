<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Resultupload extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'scan_files'=>'required',
            // 'CAMPUS_ID'=>'required | integer ',
            'EXAM_ID'=>'required | integer ',
            'STUD_ID'=>'required | integer ',
            // 'SUBJECT_ID'=>'required | integer',
        ];
    }

    //  public function messages()
    // {
    //     return [
    //         'CAMPUS_ID.required'=>'CAMPUS_ID required',
    //         'CAMPUS_ID.integer'=>'CAMPUS_ID must be an integer',
    //     ];
    // }
}
