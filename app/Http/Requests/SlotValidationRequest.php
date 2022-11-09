<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SlotValidationRequest extends FormRequest
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
            'date'    =>  ['required'],
            'time_slot'    =>  ['required'],
            'room_name'   =>  [
                                    'required', 
                                    ($method == "PUT" ? 
                                        Rule::unique('slots')
                                        ->ignore($id)
                                        ->where('date', $this->date)
                                        ->where('time_slot', $this->time_slot)
                                        ->where('room_name', $this->room_name)
                                        :
                                        Rule::unique('slots')
                                        ->where('date', $this->date)
                                        ->where('time_slot', $this->time_slot)
                                        ->where('room_name', $this->room_name)
                                    )
            ],                        
            'fee'     =>  ['required']            
        ];
    }
}
