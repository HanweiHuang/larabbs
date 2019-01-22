<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table(
            'topics' , function(Blueprint $table){
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );

        Schema::table(
            'replies', function(Blueprint $table){
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}