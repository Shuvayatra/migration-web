<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRssnewsfeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('rssnewsfeeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rss_id')->unsigned()->index()->nullable();
            $table->foreign('rss_id')->references('id')->on('rss')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nulllable();
            $table->string('permalink')->nullable();
            $table->string('post_date')->nullable();
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
        Schema::drop('rssnewsfeeds');
    }

}
