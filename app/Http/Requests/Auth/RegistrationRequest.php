<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegistrationRequest extends FormRequest
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
//            'username' => 'required|string:|max:255',
//            'role'  => 'required|string|max:100|in:charterer,shipowner',
//            'name'  => 'required|string|max:100|unique:users,name',
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|max:100',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
//            'username.required' => 'Username required',
//            'username.string' => 'The username must be a string',
//            'username.max' => 'Field username is too long',
            'name.required' => 'Name required',
            'name.string' => 'The name must be a string',
            'name.unique' => 'The name must be a unique',
            'name.max' => 'Field name is too long',
            'email.required' => 'email required',
            'email.email' => 'The name email be a email',
            'email.unique' => 'The name email be a unique',
            'email.max' => 'Field email is too long',
            'password.required' => 'Password required',
            'password.max' => 'Field password is too long',
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
                'message' => 'Registration data integrity error!',
                'code' => 1,
                'errors' => $errors,
                ], 422)); //422 Unprocessable Entity
    }
}
