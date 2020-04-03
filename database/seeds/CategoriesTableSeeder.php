<?php

use App\Category;
use App\Channel;
use App\Label;
use App\Subcategory;
use App\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = "Uno";
        $category->number = 1;
        $category->save();

        $subcategory = new Subcategory();
        $subcategory->name = "Uno Sub";
        $subcategory->number = 1;
        $subcategory->category_id = 1;
        $subcategory->save();

        $label = new Label();
        $label->name = "Uno Label";
        $label->number = 1;
        $label->subcategory_id = 1;
        $label->save();
    }
}
