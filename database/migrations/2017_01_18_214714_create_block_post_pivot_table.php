<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockPostPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'block_custom_post',
            function (Blueprint $table) {
                $table->integer('block_id')->unsigned()->index();
                $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
                $table->integer('post_id')->unsigned()->index();
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->primary(['block_id', 'post_id']);
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
        Schema::drop('block_custom_post');
    }
}
