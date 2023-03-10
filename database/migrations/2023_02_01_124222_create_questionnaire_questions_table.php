<?php

use App\Models\Questionnaire;
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
        Schema::create('questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 45);
            $table->integer('marks')->default(0);
            $table->string('question',2000);
            $table->longText('description')->nullable();
            $table->longText('data')->nullable();
            // $table->foreignIdFor(Questionnaire::class, 'questionnaire_id');
            $table->foreignIdFor(Questionnaire::class,'questionnaire_id')
                ->references('id')->on('questionnaires')
                ->onDelete('cascade');
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
        Schema::dropIfExists('questionnaire_questions');
    }
};
