<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveDepartmentRequest extends FormRequest
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
        return  [
            'short' => 'required|max:8',
            'name'  => 'required|max:255' 
        ]; 
   }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'short.required' => 'Musíťe zadať skratku odboru.',
            'short.max'      => 'Skratka odboru musí mať maximálne 8 znakov.',
            'name.required'  => 'Musíťe zadať názov odboru.',
            'name.max'       => 'Názov odboru musí mať maximálne 255 znakov.',
        ];
    }
}
