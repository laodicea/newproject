<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveNavrhZrusStnRequest extends FormRequest
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
            'kat_c' => 'required|integer',
            'ozn' => 'required|max:191',
            'nazov' => 'required|max:999',
            'zodp_zam' => 'required|max:191',
            'date_vyd' => 'date_format:"d.m.Y"|required',
            'date_nav_zru' => 'date_format:"d.m.Y"|required' 
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
            'kat_c.required' => 'Pole publikačné číslo je povinné!',
            'kat_c.integer' => 'Publikačné číslo musí byť typu integer!',
            'ozn.required' => 'Pole označenie normy je povinné!',
            'ozn.max' => 'Pole označenie normy môže mať maximálne 191 znakov!',
            'nazov.required' => 'Pole názov je povinné!',
            'nazov.max' => 'Pole názov môže mať maximálne 999 znakov!',
            'zodp_zam.required' => 'Pole zodpovedný zamestnanec je povinné!',
            'zodp_zam.max' => 'Pole zodpovedný zamestnanec musí mať maximálne 191 znakov!',
            'date_vyd.required' => 'Pole dátum vydania je povinné!',
            'date_vyd.date_format' => 'Pole dátum vydania musí byť vo formáte dd.mm.yyyy!',
            'date_nav_zru.required' => 'Pole dátum návrhu zrušenia je povinné!',
            'date_nav_zru.date_format' => 'Pole dátum návrhu zrušenia musí byť vo formáte dd.mm.yyyy!'
        ];
    }
}

