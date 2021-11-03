<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    /*public function toArray($request)
    {
        return parent::toArray($request);
    }*/
	/**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	//! В методе toArray мы возващаем массив в котором прописываем необходимые поля как ключ-значение. Берем только те поля, которые действительно необходимы. Ключ имеет произвольное название. Для удобства я называю ключи так же как и поля
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => Str::ucfirst($this->label), //первая буква заглавная
        ];
    }
}
