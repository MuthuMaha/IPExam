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
            'files'=>'required',
            'Type'=>'required | string | min:3|max:255',
            'CAMPUS_ID'=>'required | integer | min:1|max:255',
            'EXAM_ID'=>'required | integer | min:1|max:255',
            'STUD_ID'=>'required | integer | min:1|max:255',
            'SUBJECT_ID'=>'required | integer | min:1|max:255',
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
