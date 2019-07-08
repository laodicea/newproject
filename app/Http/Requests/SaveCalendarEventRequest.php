<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveCalendarEventRequest extends FormRequest
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
            'room' => 'integer',
            'title' => 'required|max:255',
            'start_date' => 'date_format:"d.m.Y H:i"',
            'end_date'   => 'date_format:"d.m.Y H:i"|after:start_date'
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
            'room.integer'           => 'Miestnosť musí byť typu integer.',
            'title.required'         => 'Pole názvu udalosti musí byť vyplnené.',
            'title.max'              => 'Názov udalosti môže mať maximálne 255 znakov.',
            'start_date.date_format' => 'Formát dátumu začatia musí byť vo forme dd.mm.yyyy hh:ii.',
            'end_date.date_format'   => 'Formát dátumu ukončenia musí byť vo forme dd.mm.yyyy hh:ii.',
            'end_date.after'         => 'Dátum ukončenia udalosti musí byť väčší ako dátum začatia udalosti.'
        ];
    }
}
