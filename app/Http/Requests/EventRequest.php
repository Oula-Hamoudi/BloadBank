<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()

    { 
        
        $imageValidateRules = 'mimes:jpg,png|min:5|max:2048';
        if($this->isMethod('post')){
            $imageValidateRules = 'required|mimes:jpg,png|min:5|max:2048';
        }
        return [
           
    
            /// condition for title unique on update
           
                'title' => 'required|min:10|max:255',
                'description' => 'required|min: 20',
                'organized_by' => 'required|min: 5',
                'image' => $imageValidateRules,
                'event_date' => 'required',
        ];
    }
}
