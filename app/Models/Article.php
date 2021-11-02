<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
	
	//public $dates = ['published_at'];
	
	//массив $fillable покажет какие поля должны быть доступны при масовом заполнении
	protected $fillable = ['title', 'body', 'img', 'slug'];
	
	//массив guarded является полной противоположностью массиву fillable. В guarded указываем какие поля не должны быть доступны и массовом заполнении
	//protected $guarded = []; //доступные все поля
	
	//У статьи может быть много комментариев
	public function comments() { //имеет несколько
        return $this->hasMany(Comment::class);
    }

    //Взаимоотношение с объектом статистики будет один-к-одному
	public function state() { //имеет один
        return $this->hasOne(State::class);
    }

    //Взаимоотношение с тегами будет многие-ко-многим
	public function tags() { //относится ко многим
        return $this->belongsToMany(Tag::class);
    }
	
	//Возвращает преобразованное поле Body, а именно: первые 100 символов
	public function getBodyPreview(){
        return Str::limit($this->body, 100);
    }

    //Возвращает преобразованное поле created_at, т.е. время когда статья была создана
	//В php есть библиотека Carbon для работы с датой и временем. Она уже встроена в Ларавел и Ларавеловские таймстампы такие как created_at, updated_at и т.д. из коробки уже работают с ф-циями данной библиотеки
	//diffForHumans - это Кабоновская ф-ция, которая преобразует дату в формат удобный для людей
	public function createdAtForHumans(){
        return $this->created_at->diffForHumans();
		//return $this->published_at->diffForHumans(); //!Тут получим ошибку: Наша кастомная дата является строкой и мы попробовали от строки вызвать ф-цию diffForHumans(), а это не сработало. !Таймстампы в Ларавеле из коробки работают с ф-циями Карбона, но это касается только таймстампов created_at и updated_at. В данном случае наш кастомный таймстамп ничего не знает о функциях Карбона. Как это исправить? В моделе Article добавим публичное свойство массив public $dates = ['published_at']; //И после этого ф-ция diffForHumans() успешно применилась к нашем кастомному таймстампу. Теперь с данным таймстампом будут работать все ф-ции библиотеки Карбон и он ничем не будет отличаться от created_at и updated_at
    }

    //Скопы - позволяют переносить в модель подобные заросы к БД
	/* //На данный момент этот скоп не является универсальным, т.к. здесь жестко прописан лимит 6 статей
	public function scopeLastLimit($query)
    {
        return $query->with('tags', 'state')->orderBy('created_at', 'desc')->limit(6)->get();
    }*/
	public function scopeLastLimit($query, $numbers)
    {
        return $query->with('tags', 'state')->orderBy('created_at', 'desc')->limit($numbers)->get();
    }

    public function scopeAllPaginate($query, $numbers)
    {
        return $query->with('tags', 'state')->orderBy('created_at', 'desc')->paginate($numbers);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->with('comments','tags', 'state')->where('slug', $slug)->firstOrFail();
    }

    public function scopeFindByTag($query)
    {
        return $query->with('tags', 'state')->orderBy('created_at', 'desc')->paginate(10);
    }
}
