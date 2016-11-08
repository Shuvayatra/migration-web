<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'rss_categories',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->boolean('status')->default(true);;

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
        Schema::drop('rss_categories');
    }
}
