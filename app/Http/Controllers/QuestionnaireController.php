<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return QuestionnaireResource::collection(Questionnaire::where('user_id', $user->id)->paginate(10));
    }

    public function store(StoreQuestionnaireRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $questionnaire = Questionnaire::create($data);

        return new QuestionnaireResource($questionnaire);
    }

    public function show(Questionnaire $questionnaire, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $questionnaire->user_id) {
            return abort(403, 'Unauthorized action');
        }

        return new QuestionnaireResource($questionnaire);
    }

    public function update(UpdateQuestionnaireRequest $request, Questionnaire $questionnaire)
    {
        $data = $request->validated();
        // Update questionnaire in the database
        $questionnaire->update($data);
        return new QuestionnaireResource($questionnaire);
    }

    public function destroy(Questionnaire $questionnaire, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $questionnaire->user_id) {
            return abort(403, 'Unauthorized action');
        }
        $questionnaire->delete();
        return response('', 204);
    }
}
