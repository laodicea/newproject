<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserRequest extends FormRequest
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
            'department_id' => 'required|integer', 
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'department_id' => ''
        ];

         $count = count($this->input('roles'))-1;
        foreach(range(0, $count) as $index){
            $rules["roles.$index"] = 'required';
            $rules["roles.$index"] = 'integer';
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
        return [
            'department_id.required' => 'Pole Odbor/oddelenie je povinný údaj!',
            'department_id.integer' => 'Pole Odbor/oddelenie musí byť typu celého čísla!',
            'lastname.required' => 'Pole Priezvisko je povinný údaj!',
            'name.required' => 'Pole Meno je povinný údaj!',
            'email' => 'Pole Email musí byť v tvare emailu!',
            'roles.integer' => 'Pole Rola usí byť zaznačené ako celé!',
            'roles.required' => 'Pole Rola je je povinný údaj!' 
        ];
    }
}
