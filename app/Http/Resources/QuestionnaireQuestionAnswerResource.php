<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireQuestionAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'answer' => $this->answer,
            'description' => $this->description,
            'question' => $this->question,
            'type' => $this->type,
            'marks' => $this->marks,
            'data' => json_decode($this->data)
        ];
    }
}
