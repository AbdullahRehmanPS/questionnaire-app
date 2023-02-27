<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionnaireAnswerResourceResponse;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
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
        $record = QuestionnaireAnswer::where('id', $id)->first();
        $questionnaire_id = $record->questionnaire_id;

        return [
            'questionnaire' => QuestionnaireResource::collection(Questionnaire::where('id', $questionnaire_id)->get()),
            'response' => QuestionnaireAnswerResourceResponse::collection(QuestionnaireAnswer::where('id', $id)->get()),
            //'response' => new QuestionnaireAnswerResourceResponse($id)
        ];
    }
}
