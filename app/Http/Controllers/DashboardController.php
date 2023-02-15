<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionnaireAnswerResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();

        // Total Number of Questionnaire
        $total = Questionnaire::query()->where('user_id', $user->id)->count();

        // Latest Questionnaire
        $latest = Questionnaire::query()->where('user_id', $user->id)->latest('created_at')->first();

        // Total Number of answers
        $totalAnswers = QuestionnaireAnswer::query()
            ->join('questionnaires', 'questionnaire_answers.questionnaire_id', '=', 'questionnaires.id')
            ->where('questionnaires.user_id', $user->id)
            ->count();

        // Latest 5 answer
        $latestAnswers = QuestionnaireAnswer::query()
            ->join('questionnaires', 'questionnaire_answers.questionnaire_id', '=', 'questionnaires.id')
            ->where('questionnaires.user_id', $user->id)
            ->orderBy('end_date', 'DESC')
            ->limit(5)
            ->getModels('questionnaire_answers.*');

        return [
            'totalQuestionnaires' => $total,
            //'latestQuestionnaires' => $latest ? new SurveyResourceDashboard($latest) : null,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => QuestionnaireAnswerResource::collection($latestAnswers)
        ];

    }
}
