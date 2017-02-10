<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdRssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'rss',
            function ($table) {
                $table->integer('category_id')->unsigned()->index()->nullable();
                $table->foreign('category_id')
                      ->references('id')->on('rss_categories')
                      ->onDelete('cascade')->nullable();
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
        Schema::table(
            'rss',
            function ($table) {
                $table->dropColumn('category_id');
            }
        );
    }
}
