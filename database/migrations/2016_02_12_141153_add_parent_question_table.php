<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'questions',
            function ($table) {
                $table->integer('parent_id')->unsigned()->nullable()->index()->default(0);
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
        Schema::table(
            'questions',
            function ($table) {
                $table->dropColumn('parent_id');
            }
        );
    }
}
