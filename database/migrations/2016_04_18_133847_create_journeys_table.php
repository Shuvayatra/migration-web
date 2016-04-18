<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'journeys',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('menu_image');
                $table->string('featured_image');
                $table->string('small_menu_image');
                $table->integer('position');
                $table->boolean('status')->default(false);
                $table->timestamps();
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
        Schema::drop('journeys');
    }

}
