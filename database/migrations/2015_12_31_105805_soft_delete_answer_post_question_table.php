<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDeleteAnswerPostQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function ($table) {
            $table->softDeletes();
        });
        Schema::table('answers', function ($table) {
            $table->softDeletes();
        });
        Schema::table('posts', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('answers', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('posts', function ($table) {
            $table->dropColumn('deleted_at');
        });
    }
}
