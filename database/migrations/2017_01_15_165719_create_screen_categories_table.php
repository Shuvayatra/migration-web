<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreenCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'screen_feeds',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('screen_id')->unsigned()->index();
                $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
                $table->integer('category_id')->unsigned()->index();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                $table->string('category_type')->nullable();
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
        Schema::drop('screen_feeds');
    }
}
