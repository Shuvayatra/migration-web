<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'posts',
            function (Blueprint $table) {
                $table->increments('id');
                $table->json('metadata');
                $table->integer('created_by');
                $table->integer('updated_by');
                $table->foreign('created_by')
                      ->references('id')->on('users')
                      ->onDelete('cascade')->nullable();
                $table->foreign('updated_by')
                      ->references('id')->on('users')
                      ->onDelete('cascade')->nullable();
                $table->timestamps();
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
        Schema::drop('posts');
    }

}
