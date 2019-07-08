<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveInformSecurityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'securitycategories_id' => 'integer',
        ];
        if(is_null('uploaded_files')){        
            $count = count($this->input('uploaded_files'))-1; 
            foreach(range(0, $count) as $index){ 
                $rules["uploaded_files.$index"]= 'nullable|mimes:text,pdf,xls,doc,docx,png,jpeg,jpg,ppt,pptx,xlsx,rar,zip|max:1500';
            }
        }
        return $rules;
    } 

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    { 
        $messages = [];
        if(is_null('uploaded_files')){ 
            foreach($this->file('uploaded_files') as $key => $val){
                $messages["uploaded_files.$key.mimes"] = "Všetky súbory musia byť typu :values!";
            }
        } 
        $messages = [
            'name.required' => 'Pole názov je povinnné.',
            'name.max'      => 'Názov oznamu musí mať maximálne 255 znakov.',
            'description.required' => 'Popis informačnej bezpečnosti je povinné pole',
            'securitycategories_id.integer' => 'Musíťe vybrať bezpečnostnú kategóriu.',
        ];
            
        return $messages;
    }
}
