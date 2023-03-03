<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';

    protected $fillable = ['user_id', 'title', 'description', 'expire_date', 'total_marks'];

    public function questions() {
        return $this->hasMany(QuestionnaireQuestion::class);
    }
    public function answers() {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
}
