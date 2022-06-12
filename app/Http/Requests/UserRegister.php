<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegister extends FormRequest
{

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(bad_request($validator->errors()->first()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users|email:rfc,dns',
            'rules_id' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'country_code' => 'required',
            'country' => 'required'
        ];
    }
}