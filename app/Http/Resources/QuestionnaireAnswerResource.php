<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class QuestionnaireAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sdfgh= 0;
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'questionnaire' => new QuestionnaireResource($this->questionnaire),
            'name' => $this->name,
            'email' => $this->email,
            'total_marks' => $this->total_marks,
            'end_date' => (new DateTime($this->end_date))->format('Y-m-d H:i:s')
        ];
    }
}
