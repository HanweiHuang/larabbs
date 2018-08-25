<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => 'Share',
                'description' => 'Share Ideas，Share Discovery',
            ],
            [
                'name'        => 'Course',
                'description' => 'Develop Skills、Recommend Extend Packages',
            ],
            [
                'name'        => 'Q&A',
                'description' => 'Friendly and help each other',
            ],
            [
                'name'        => 'Notice',
                'description' => 'Site Notice',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
