<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class WorkingTimeRequest extends FormRequest
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
            'user_id'  => ['required', 'integer'],
            'date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'count' => ['required', 'integer'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'user_id'  => 'Auth user id',
            'date' => 'Report on date',
            'count' => 'Week count',
        ];
    }

    /**
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
