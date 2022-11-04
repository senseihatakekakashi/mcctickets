<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EFormPermissionToEnterDateValidationRequest extends FormRequest
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
        return [            
            'date'                                          =>  [
                                                                    'required', 
                                                                    Rule::unique('e_form_permission_to_enter_dates')
                                                                    ->where('e_form_permission_to_enter_particular_id', Crypt::decryptString($this->foreign_id))
                                                                    ->where('date', $this->date)
                                                                    ->where('time', $this->time)
                                                                ],
            'time'                                          =>  ['required']
        ];
    }
}
