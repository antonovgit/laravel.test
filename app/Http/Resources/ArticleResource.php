<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	//Я сделал так, чтобы статья сохранила все свои связи. Т.е. когда я обращусь к статье к полю comments, я хочу видеть все связанные комментарии. Сатья это будет не простой массив, а массив содержащий в себе вложенные массивы - комментариев, тегов и статистики..ведь в Vue Js компонент мне необходимо будет передавать только один массив с данными. Значением ключей комментариев и тегов является коллекция ресурсов. Им передается релейшеншип comments и tags. По другому дело обстоит со статистикой, т.к. у нас не коллекция, у нас один эл..просто создается новый ресурс статистики и передается релейшеншип state
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'img' => $this->img,
            'body' => $this->body,
            'created_at' => $this->createdAtForHumans(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'statistic' => new StateResource($this->whenLoaded('state')),
        ];
    }
}
