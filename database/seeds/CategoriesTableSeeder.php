<?php

use App\Models\Category;
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
        $faker = app(Faker\Generator::class);

        $categories = factory(Category::class)
            ->times(4)
            ->make()
            ->each(function ($category, $index) use($faker) {
                $category->name = $faker->name;
                $category->description = $faker->sentence();
            });

        Category::insert($categories->toArray());
    }
}


