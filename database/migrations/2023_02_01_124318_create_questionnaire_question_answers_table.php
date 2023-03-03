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
            //$table->foreignIdFor(QuestionnaireQuestion::class, 'questionnaire_question_id');
            $table->foreignIdFor(QuestionnaireQuestion::class,'questionnaire_question_id')
                ->references('id')->on('questionnaire_questions')
                ->onDelete('cascade');
            //$table->foreignIdFor(QuestionnaireAnswer::class, 'questionnaire_answer_id');
            $table->foreignIdFor(QuestionnaireAnswer::class,'questionnaire_answer_id')
                ->references('id')->on('questionnaire_answers')
                ->onDelete('cascade');
            $table->text('answer');
            $table->integer('obtained_marks')->default(0);
            //$table->uuid('answer_uuid')->unique();
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
