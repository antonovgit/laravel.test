<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Comment;


class AddNewComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; //кол-во попыток

    protected $body;
    protected $subject;
    protected $article_id;

	
	//Для того чтобы передать в наш класс переменные с данными комментария, добавим конструктор
    public function __construct($subject, $body, $article_id)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->article_id = $article_id;
    }

    //В методе handle происходит создание нового комментария
	public function handle()
    {
        $comment = Comment::create([
            'subject' => $this->subject,
            'body' => $this->body,
            'article_id' => $this->article_id
        ]);
    }
}
