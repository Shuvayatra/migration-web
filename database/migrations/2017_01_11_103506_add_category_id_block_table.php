<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'blocks',
            function ($table) {
                $table->integer('show_country_id')->unsigned()->index()->nullable();
                $table->foreign('show_country_id')
                      ->references('id')->on('categories')
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
            'blocks',
            function ($table) {
                $table->dropColumn('show_country_id');
            }
        );
    }
}
