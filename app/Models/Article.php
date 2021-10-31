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
	
	public function getBodyPreview(){
        return Str::limit($this->body, 100);
    }

    public function createdAtForHumans(){
        return $this->created_at->diffForHumans();
//        return $this->published_at->diffForHumans();
    }

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
