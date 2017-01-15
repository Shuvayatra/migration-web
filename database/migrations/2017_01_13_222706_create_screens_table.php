<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'screens',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('title');
                $table->string('icon_image')->nullable();
                $table->enum('type', ['block', 'feed'])->default('block');
                $table->json('visibility');
                $table->boolean('is_published')->default(false);
                $table->integer('position');
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
        Schema::drop('screens');
    }
}
