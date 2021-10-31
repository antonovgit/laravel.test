<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $tags = \App\Models\Tag::factory(10)->create(); //создаст 10 тегов..коллекция

        $articles = \App\Models\Article::factory(20)->create(); //создаст 20 статей..коллекция

        //pluck пройдет по всем эл коллекции и сохраняет в массив значения данных полей. В данном случае мы сохраняем все айдишники всех тегов в масив
		$tags_id = $tags->pluck('id');
        // https://laravel.com/docs/8.x/collections#method-pluck

        //В цикле each проходим по коллекции статей. Для каждой статьи , мы использя связь tags(), мы заполняем сводную таблицу тремя рандомными тегами из tags_id. Дальше для каждой статьи мы создаем три комментария, используя $article->id каждой конкретной статьи. Так же мы для каждой статьи создаем один эл статистики, так же использем $article->id
		//В итоге у нас будет 10 тегов, 20 статей. Для каждой статьи у нас будет связь с тремя тегами. У нас будет 3 комментария и один набор статистических данных
		$articles->each(function ($article) use ($tags_id) {
            $article->tags()->attach($tags_id->random(3));
            \App\Models\Comment::factory(3)->create([
                'article_id' => $article->id
            ]);

            \App\Models\State::factory(1)->create([
                'article_id' => $article->id
            ]);
        });

    }
}