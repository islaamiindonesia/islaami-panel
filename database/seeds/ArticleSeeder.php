<?php

use App\Article;
use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new ArticleCategory();
        $category->name = "App Policy";
        $category->save();

        $article = new Article();
        $article->title = "Article Uno";
        $article->content = "Lorem <b>ipsum</b> <u>dolor</u> <i>sit</i> amet";
        $article->category_id = 1;
        $article->save();
    }
}
