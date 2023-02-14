<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['questionnaire_question_id', 'questionnaire_answer_id', 'answer'];
}
