<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'email'=>'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:8',
        ];
    }

    protected function failedValidation(Validator $validator){
        $error_response = [
            'code' => 200,
            'status' => false,
            'message' =>  $validator->errors()->first(),
            'data' => \Request::all()
        ];
        throw new HttpResponseException(response()->json($error_response,200));
    }
}
