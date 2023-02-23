<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionnaireAnswerResource;
use App\Http\Resources\QuestionnaireAnswerResourceResponse;
use App\Models\QuestionnaireAnswer;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function getResponses(Request $request, $id) {
        $number = intval($id);
        $responses = QuestionnaireAnswer::where('questionnaire_id', $id)->get();
        return $responses;
        //return QuestionnaireAnswerResourceResponse::collection(QuestionnaireAnswer::where('questionnaire_id' ,$number));
    }
}
