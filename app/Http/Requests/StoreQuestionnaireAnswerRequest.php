<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireAnswerRequest extends FormRequest
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
            //'answers' => 'required|array',
            'answers' => 'array',
            'data.name' => 'required|regex:/^[A-Za-z\s]+$/',
            'data.email' => 'required|email'
            //'email' => 'required|email|unique:students,email',
        ];
    }
}
