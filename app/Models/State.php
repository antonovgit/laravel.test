<?php
//Отношения здесь не указываются. Мы всегда будем статистику доставать из статьи. Никогда не будем статью из статистики

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['likes', 'views', 'article_id'];
    
	//По умолчанию Eloquent ожидает наличие в наших таблицах столбцов created_at и updated_at..временные метки(timestamps). В случае с моделями Eloquent эти поля будут заполнятся моделью автоматически датой и временем. Если мы не хотим чтобы эти поля заполнялись автоматически, тогда существует публичное свойсово $timestamps и мы его должны выставить в фолс. В этом случае Ларавель не будет следить за заполнением этих полей
	public $timestamps = false; //ОТКЛЮЧАЕМ! чтобы автоматически не заполнялись в БД поля updated_at и created_at
}
