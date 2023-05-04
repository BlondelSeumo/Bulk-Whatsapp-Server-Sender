<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\Phone;
class Bulkrequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $validators= [
            'appkey' => 'required|max:60',
            'authkey' => 'required|max:60',
            'to' => ['required','max:13',new Phone],           
        ];

        

        if(empty($request->message)){
            $validators['template_id'] = 'required';
        }

        if (empty($request->template_id)) {
            $validators['message'] = 'required|max:1000';
        }

        if (!empty($request->variables)) {
           $validators['template_id'] = 'required';
        }

      
        return $validators;
    }

    public function failedValidation(Validator $validator)
    {
     
        throw new HttpResponseException(response()->json([
               'success'   => false,
               'message'   => 'Validation errors',
               'data'      => $validator->errors()
        ]));
    }
}
