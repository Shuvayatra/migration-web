<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPostPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'similar_posts',
            function (Blueprint $table) {
                $table->integer('post_id')->unsigned()->index();
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->integer('similar_post_id')->unsigned()->index();
                $table->foreign('similar_post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->primary(['post_id', 'similar_post_id']);
                $table->softDeletes();
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
        Schema::drop('similar_posts');
    }
}
