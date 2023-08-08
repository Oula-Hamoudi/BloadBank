<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBloodRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_name'=>'required|min:5|max:255',
            'gender' => 'required',
            'blood_group'=> 'required',
            'blood_unit'=> 'required|integer' ,
            'hospital_name'=> 'required|min:5|max:255' ,
            'division'=> 'required' ,
            'district'=> 'required' ,
            'thana'=> 'required' ,
            'postOffice'=> 'required' ,
            'postCode'=> 'required' ,
            'require_date'=> 'required|date' ,
            'contact_name'=> 'required|min:5|max:255' ,
            'email'=> 'required|email' ,
            'phone'=> 'required' ,
            'reason'=> 'required|min:5|max:255' ,
            'official_report'=> 'mimes:jpg,png|min:5|max:2048'
        ];
    }
}
