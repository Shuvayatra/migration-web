<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_logger', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request_url');
            $table->text('request_data');
            $table->json('response')->nullable();
            $table->integer('status');
            $table->string('method');
            $table->json('header');
            $table->string('host');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('api_logger');
    }
}
