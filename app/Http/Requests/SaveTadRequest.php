<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveTadRequest extends FormRequest
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
        return [
            'skterm' => 'required', 
            'kat_c' => 'required|integer'
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
            'skterm.required'   => 'Pole "Slovenský termín" musí byť vyplnené!', 
            'kat_c.required'    => 'Pole "Publikačné číslo" musí byť vyplnené!',
            'kat_c.integer'     => 'Pole "Publikačné číslo" musí byť typu integer!'
        ];
    }
}
