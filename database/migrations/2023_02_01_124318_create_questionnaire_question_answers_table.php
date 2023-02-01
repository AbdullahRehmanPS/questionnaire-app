<?php

use App\Models\QuestionnaireAnswer;
use App\Models\QuestionnaireQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(QuestionnaireQuestion::class, 'questionnaire_question_id');
            $table->foreignIdFor(QuestionnaireAnswer::class, 'questionnaire_answer_id');
            $table->text('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_question_answers');
    }
};
