<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'blocks',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('page')->default('home');;
                $table->json('metadata');
                $table->boolean('is_active')->default(true);
                $table->integer('position');
                $table->integer('created_by');
                $table->integer('updated_by');
                $table->foreign('created_by')
                      ->references('id')->on('users')
                      ->onDelete('cascade')->nullable();
                $table->foreign('updated_by')
                      ->references('id')->on('users')
                      ->onDelete('cascade')->nullable();
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
        Schema::drop('blocks');
    }

}
