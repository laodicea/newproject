<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveDatasetRequest extends FormRequest
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
           'dataset'             => 'required|max:255',
           'nazov_dataset'       => 'required|max:255',
           'short'               => 'required|max:255',
           'spravca'             => 'required|max:255',
           'povinna_institucia'  => 'required|max:255',
           'kontakt_zastupcu'    => 'required|max:255',
           'tel'                 => 'required|max:255',
           'stav_elektronizacie' => 'required|max:255',
           'format'              => 'required|max:255',
           'rozsah_udajov'       => 'required|max:255',
           'aktualizacia_udajov' => 'required|max:255',
           'spceifikacia_obsahu' => 'required|max:255',
           'zverejnitelnost'     => 'required|max:255',
           'odovodnenie'         => 'required|max:255',
           'plan_zverejnenia'    => 'date'
        ];
    }
}

 
