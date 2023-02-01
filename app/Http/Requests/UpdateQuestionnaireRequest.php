<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionnaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $questionnaire = $this->route('questionnaire');
        if ($this->user()->id !== $questionnaire->user_id) {
            return false;
        }
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
            'title' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
            'questions' => 'array',
        ];
    }
}
