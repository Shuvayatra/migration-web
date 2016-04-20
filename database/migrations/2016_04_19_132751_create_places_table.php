<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'places',
            function (Blueprint $table) {
                $table->increments('id');
                $table->json('metadata');
                $table->string('image');
                $table->boolean('status')->default(false);
                $table->integer('country_id')->foreign('country_id')->references('id')->on('country')->onDelete(
                    'cascade'
                );
                $table->softDeletes();
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
        Schema::drop('places');
    }

}
