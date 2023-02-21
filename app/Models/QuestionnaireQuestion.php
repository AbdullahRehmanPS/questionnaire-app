<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'data', 'type', 'marks', 'questionnaire_id', 'description'];

    public function questionnaire() {
        return $this->belongsTo(Questionnaire::class);
    }
}
