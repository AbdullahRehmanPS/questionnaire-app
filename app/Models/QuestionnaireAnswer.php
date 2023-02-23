<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    use HasFactory;
    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $fillable = ['questionnaire_id', 'name', 'email', 'start_date', 'end_date'];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

}
