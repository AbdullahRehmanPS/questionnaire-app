<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionnaireAnswerRequest;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $totalMarks = 0;
        // Create new questions
        foreach ($data['questions'] as $question) {
            $question['questionnaire_id'] = $questionnaire->id;
            $validator = Validator::make($question, [
                'marks' => 'required|numeric|min:0',
            ]);
            $totalMarks += $validator->validated()['marks'];
            $this->createQuestion($question);
        }
        $questionnaire->total_marks = $totalMarks;
        $questionnaire->save();
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
        //
        $totalMarks = 0;
        //
        // Get ids as plain array of existing questions
        $existingIds = $questionnaire->questions()->pluck('id')->toArray();
        // Get ids as plain array of new questions
        $newIds = Arr::pluck($data['questions'], 'id');
        // Find questions to delete
        $toDelete = array_diff($existingIds, $newIds);
        //Find questions to add
        $toAdd = array_diff($newIds, $existingIds);

        // Delete questions by $toDelete array
        QuestionnaireQuestion::destroy($toDelete);

        // Create new questions
        foreach ($data['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['questionnaire_id'] = $questionnaire->id;

                $validator = Validator::make($question, [
                    'marks' => 'required|numeric|min:0',
                ]);
                $totalMarks += $validator->validated()['marks'];

                $this->createQuestion($question);
            }
        }

        // Update existing questions
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($questionnaire->questions as $question) {
            //$newQuestion = $question;
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);

                $totalMarks += $question['marks'];

            }
        }

        $questionnaire->total_marks = $totalMarks;
        $questionnaire->save();

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

    private function createQuestion($data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'type' => ['required', Rule::in([
                Questionnaire::TYPE_TEXT,
                Questionnaire::TYPE_TEXTAREA,
                Questionnaire::TYPE_RADIO,
                Questionnaire::TYPE_SELECT,
                Questionnaire::TYPE_CHECKBOX,
            ])],
            'marks' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'data' => 'present',
            'questionnaire_id' => 'exists:App\Models\Questionnaire,id'
        ]);

        return QuestionnaireQuestion::create($validator->validated());
    }

    private function updateQuestion(QuestionnaireQuestion $question, $data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'id' => 'exists:App\Models\QuestionnaireQuestion,id',
            'question' => 'required|string',
            'type' => ['required', Rule::in([
                Questionnaire::TYPE_TEXT,
                Questionnaire::TYPE_TEXTAREA,
                Questionnaire::TYPE_SELECT,
                Questionnaire::TYPE_RADIO,
                Questionnaire::TYPE_CHECKBOX,
            ])],
            'marks' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'data' => 'present',
        ]);
        return $question->update($validator->validated());
    }

    public function storeAnswer(StoreQuestionnaireAnswerRequest $request, Questionnaire $questionnaire)
    {
        $validated = $request->validated();
        $data = $validated['data'];
        $questionnaireAnswer = QuestionnaireAnswer::create([
            'questionnaire_id' => $questionnaire->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
        ]);

        //$questionId => $answer will be an associated array where $questionId will be the key and their
        // values will be answers
        foreach ($validated['answers'] as $questionId => $answer) {
            $question = QuestionnaireQuestion::where(['id' => $questionId, 'questionnaire_id' => $questionnaire->id])->get();
            if (!$question) {
                return response("Invalid question ID: \"$questionId\"", 400);
            }

            $data = [
                'questionnaire_question_id' => $questionId,
                'questionnaire_answer_id' => $questionnaireAnswer->id,
                'answer' => is_array($answer) ? json_encode($answer) : $answer
            ];

            $questionAnswer = QuestionnaireQuestionAnswer::create($data);
        }
        return response('', 201);
    }
}
