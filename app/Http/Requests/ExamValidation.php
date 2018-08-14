<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamValidation extends FormRequest
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
        if(request()->segment(2)=='ip-create')
       $rules=[
            'Exam_Name'=>'required',
            'Date_Exam'=>'required',
            'Test_Type_Id'=>'required',
            'Board'=>'required',
            'Group_Id'=>'required',
            'Classyear_Id'=>'required',
            'Stream_Id'=>'required',
            'Program_Id'=>'required',
        ];

        return $rules;
    } 
     public function messages()
    {
        return [
            'Exam_Name.required'=>'Exam_Name is required',
            'Date_Exam.required'=>'Date_Exam isrequired',
            'Test_Type_Id.required'=>'Test_type_Id is required',
            'Board.required'=>'Board is required',
            'Group_Id.required'=>'Group_Id is required',
            'Classyear_Id.required'=>'Classyear_Id is required',
            'Stream_Id.required'=>'Stream_Id is required',
            'Program_Id.required'=>'Program_Id is required',
        ];
    }
}
