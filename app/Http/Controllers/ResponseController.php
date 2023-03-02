<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionnaireAnswerResourceResponse;
use App\Http\Resources\QuestionnaireQuestionAnswerResource;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use App\Models\QuestionnaireQuestionAnswer;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function getResponses(Request $request, $id)
    {
        //$responses = QuestionnaireAnswer::where('questionnaire_id', $id)->get();
        $responses = QuestionnaireAnswerResourceResponse::collection(QuestionnaireAnswer::where('questionnaire_id', $id)->get());
        return $responses;
    }

    public function getResponse(Request $request, $id)
    {
        $UserId = intval($id); //response(each answer) ki id
        $record = QuestionnaireAnswer::where('id', $id)->first();
        $questionnaire_id = $record->questionnaire_id; //Questionnaire ki id
        $questionnaireAnswerId = $record->id;

        $questionnaireAndQuestions = Questionnaire::where('id', $questionnaire_id)->get(); //Questionnaire or questions dono
        $questionnaire = QuestionnaireResource::collection($questionnaireAndQuestions);

        $question = $questionnaire->pluck('questions'); //questions in questionnaire

        $singleResponse = QuestionnaireAnswer::where('id', $UserId)->get(); //ek response (each Answer)

        $questionsWithAnswers = QuestionnaireQuestionAnswer::query()
            ->select('qq.question', 'qq.description', 'qq.data', 'qq.type', 'qqa.answer')
            ->from('questionnaires as q')
            ->join('questionnaire_answers as qa', 'q.id', '=', 'qa.questionnaire_id')
            ->join('questionnaire_questions as qq', 'qq.questionnaire_id', '=', 'q.id')
            ->join('questionnaire_question_answers as qqa', function ($join) {
                $join->on('qqa.questionnaire_answer_id', '=', 'qa.id')
                    ->on('qqa.questionnaire_question_id', '=', 'qq.id');
            })
            ->where('q.id', '=', $questionnaire_id)
            ->where('qa.id', '=', $UserId)
            ->get();

        return [
//            'questionsWithAnswers' => $questionsWithAnswers,
            'questionsWithAnswers' => QuestionnaireQuestionAnswerResource::collection($questionsWithAnswers),
            'questionnaire' => $questionnaire,
            'response' => QuestionnaireAnswerResourceResponse::collection($singleResponse),
        ];
    }
}
//$questionDecode = json_decode($question);
//foreach ($questionDecode as $questionInd) {
//    $abc = $questionInd;
//}
