<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'notices',
            function (Blueprint $table) {
                $table->increments('id');
                $table->json('metadata');
                $table->integer('country_id')->unsigned()->nullable();
                $table->foreign('country_id')
                      ->references('id')->on('categories')
                      ->onDelete('cascade')->nullable();
                $table->boolean('status')->default(false);;
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
        Schema::drop('notices');
    }

}
