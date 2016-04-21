<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryattributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'category_attributes',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('main_image')->nullable();
                $table->string('icon')->nullable();
                $table->string('small_icon')->nullable();
                $table->integer('position');
                $table->string('section_id')->nullable();
                $table->integer('parent_id')
                      ->foreign('parent_id')
                      ->references('id')
                      ->on('category_attributes')
                      ->onDelete(
                          'cascade'
                      );
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
        Schema::drop('category_attributes');
    }

}
