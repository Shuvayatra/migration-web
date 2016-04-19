<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneySubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'journey_subcategories',
            function (Blueprint $table) {
                $table->increments('id');
                $table->text('title');
                $table->integer('position');
                $table->boolean('status')->default(true);
                $table->integer('journey_id')->foreign('journey_id')->references('id')->on('journeys')->onDelete(
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
        Schema::drop('journey_subcategories');
    }
}
