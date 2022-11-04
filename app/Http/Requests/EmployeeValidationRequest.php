<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EmployeeValidationRequest extends FormRequest
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
        $method = $this->request->get('_method');        

        if($method == "PUT") {
            try {                                
                $id = Crypt::decryptString($this->request->get('_id'));            
            } catch (DecryptException $e) {
                abort(403);
            } 
        }
                        
        return [            
            // Note: Ignore unique validation if the process is update            
            'employee_mcc_id'   =>  ['required', ($method == "PUT" ? Rule::unique('employees')->ignore($id) : 'unique:employees')],
            'last_name'         =>  ['required'],
            'first_name'        =>  ['required'],
            'date_of_birth'     =>  ['required', 'date'],
            'place_of_birth'    =>  ['required'],
            'sex'               =>  ['required'],
            'civil_status'      =>  ['required'],            
            'email_address'     =>  ['email', ($method == "PUT" ? Rule::unique('employees')->ignore($id) : 'unique:employees')]
        ];
    }
}
